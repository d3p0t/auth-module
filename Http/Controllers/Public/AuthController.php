<?php

namespace Modules\Auth\Http\Controllers\Public;

use App\Providers\RouteServiceProvider;
use Modules\Auth\Http\Controllers\AuthController as Controller;

class AuthController extends Controller
{
    
    public function loginPage(): string
    {
        return 'auth::public.auth.login';
    }

    public function forgotPasswordPage(): string
    {
        return 'auth::public.auth.forgot-password';
    }

    public function resetPasswordPage(): string
    {
        return 'auth::public.auth.reset-password';
    }


    public function resetPasswordRedirect(): string {
        return 'auth/login';
    }

    public function homePage(): string
    {
        return RouteServiceProvider::HOME;
    }
}
