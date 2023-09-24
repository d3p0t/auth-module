<?php

namespace Modules\Auth\Http\Controllers;

use Modules\Auth\Entities\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController as Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\ResetPasswordRequest;
use Modules\Auth\Services\AuthService;

abstract class AuthController extends Controller
{

    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Shows the login page
     * @return Renderable
     */
    public function showLogin() {
        if ($this->authService->getCurrentUser()) {
            return redirect()->to(RouteServiceProvider::HOME);
        }
        return view($this->loginPage());
    }

    abstract function loginPage(): string;
    abstract function forgotPasswordPage(): string;
    abstract function resetPasswordPage(): string;
    abstract function resetPasswordRedirect(): string;

    /**
     * Tries to login the user
     * @return Renderable
     */
    public function login(LoginRequest $request) {
        if ($this->authService->getCurrentUser()) {
            return redirect()->back();
        }

        $validated = $request->validated();

        if (
            $this->authService->login(
                $validated['username'],
                $validated['password'],
                $validated['remember']
            )
        ) {
            $request->session()->regenerate();

            $request->session()->put('locale', $this->authService->getCurrentUser()->locale);

            return redirect()->to($validated['redirect']);
        }

        return back()->withErrors([
            'username' => 'Invalid credentials'
        ])->onlyInput('username');
    }

    /** 
     * Logs the user out and redirects back to the previous page
     */
    public function logout(Request $request)
    {
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
    public function showForgotPassword() {
        if ($this->authService->getCurrentUser()) {
            return redirect()->back();
        }
        return view($this->forgotPasswordPage());
    }

    public function forgotPassword(Request $request) {
        $request->validate(['email' => 'required|email']);
 
        $status = Password::sendResetLink(
            $request->only('email')
        );
     
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPassword(Request $request, String $token) {
        if ($this->authService->getCurrentUser()) {
            return redirect()->back();
        }

        if ($this->checkToken($token, $request->input('email'))) {
            return view($this->resetPasswordPage(), [
                'token' => $token
            ]);
        }

        return view($this->resetPasswordPage(), [
            'error' => 'Token has already been used'
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request) {
        $validated = $request->validated();

        $status = Password::reset($validated, function(User $user) {

            $user->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        });

        return $status === Password::PASSWORD_RESET
            ? redirect($this->resetPasswordRedirect())->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    private function checkToken(string $token, string $email): bool
    {

        $password_resets = DB::table('password_reset_tokens')->where('email', $email)->first();

        if ($password_resets &&  Hash::check($token, $password_resets->token)) {
            $createdAt = Carbon::parse($password_resets->created_at);
            if (!Carbon::now()->greaterThan($createdAt->addMinutes(config('auth.passwords.users.expire')))) {
                return true;
            }
        }

        return false;
    }

}
