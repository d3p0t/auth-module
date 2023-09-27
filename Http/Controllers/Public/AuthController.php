<?php

namespace Modules\Auth\Http\Controllers\Public;

use App\Providers\RouteServiceProvider;
use Modules\Auth\Http\Controllers\AuthController as Controller;

class AuthController extends Controller
{
    
    public function loginPage(): string
    {
        return 'auth::public.login.show';
    }

    public function forgotPasswordPage(): string
    {
        return 'auth::public.forgot-password.show';
    }

    public function resetPasswordPage(): string
    {
        return 'auth::public.reset-password.show';
    }

    public function changePasswordPage(): string {
        return 'auth::public.change-password.show';
    }

    public function resetPasswordRedirect(): string {
        return 'auth/login';
    }

    public function homePage(): string
    {
        return RouteServiceProvider::HOME;
    }
}
