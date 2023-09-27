<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Modules\Auth\Http\Requests\ChangePasswordRequest;
use Modules\Auth\Http\Requests\ForgotPasswordRequest;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\ResetPasswordRequest;
use Modules\Auth\Services\AuthService;
use Modules\Auth\Services\PasswordService;

abstract class AuthController extends Controller
{

    private AuthService $authService;
    private PasswordService $passwordService;

    public function __construct(AuthService $authService, PasswordService $passwordService)
    {
        $this->authService = $authService;
        $this->passwordService = $passwordService;
    }

    /**
     * Get the Login Page view
     * @return String
     */
    abstract function loginPage(): String;

    /**
     * Get the Forgot Password Page view
     * @return String
     */
    abstract function forgotPasswordPage(): String;

    /**
     * Get the Reset Password Page view
     * @return String
     */
    abstract function resetPasswordPage(): String;

    /**
     * Get the Reset Password redirect link
     * @return String
     */
    abstract function resetPasswordRedirect(): String;

    /**
     * Get the Home Page view
     * @return String
     */
    abstract function homePage(): String;

    /**
     * Get the Change Password view
     * @return String
     */
    abstract function changePasswordPage(): String;
    
    /**
     * Shows the login page
     * @return Renderable|RedirectResponse
     */
    public function showLogin(): Renderable|RedirectResponse {
        return $this->authService->getCurrentUser() ? redirect()->to($this->homePage()) : view($this->loginPage());
    }

    /**
     * Attemps to login the user
     * @return RedirectResponse
     */
    public function login(LoginRequest $request): RedirectResponse {
        if ($this->authService->getCurrentUser()) {
            return redirect()->back();
        }

        if (
            $this->authService->login(
                $request->validated('username'),
                $request->validated('password'),
                $request->validated('remember')
            )
        ) {
            $request->session()->regenerate();
            $request->session()->put('locale', $this->authService->getCurrentUser()->locale);

            return redirect()->to($request->validated('redirect'));
        }

        return back()->withErrors([
            'username' => 'Invalid credentials'
        ])->onlyInput('username');
    }

    /** 
     * Logs the user out and redirects back to the previous page
     * 
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse {
        if ($this->authService->logout()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->back();
        } else {
            abort(401);
        }
    }

    /**
     * Renders the forgot password page
     */
    public function showForgotPassword(): Renderable {
        return $this->authService->getCurrentUser() ? redirect()->back() : view($this->forgotPasswordPage());
    }

    public function forgotPassword(ForgotPasswordRequest $request): RedirectResponse {
        $status = $this->passwordService->sendResetLink($request->validated('email'));

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Renders the Rest Password page
     */
    public function showResetPassword(Request $request, String $token): Renderable {
        if ($this->authService->getCurrentUser()) {
            return redirect()->back();
        }

        if ($this->passwordService->checkResetPasswordToken($token, $request->input('email'))) {
            return view($this->resetPasswordPage(), [
                'token' => $token
            ]);
        }

        return view($this->resetPasswordPage(), [
            'error' => 'Token has already been used'
        ]);
    }

    /**
     * Resets the password
     */
    public function resetPassword(ResetPasswordRequest $request): RedirectResponse {
        $status = $this->passwordService->resetPassword(
            $request->validated('token'),
            $request->validated('email'),
            $request->validated('password'),
            $request->validated('password_confirmation')
        );

        return $status === Password::PASSWORD_RESET
            ? redirect($this->resetPasswordRedirect())->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function changePassword(ChangePasswordRequest $request): RedirectResponse {
        $this->passwordService->changePassword(
            $this->authService->getCurrentUser(),
            $request->password()
        );

        return redirect()->back()
            ->with('status', 'Password is changed');
    }

}
