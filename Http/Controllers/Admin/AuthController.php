<?php

namespace Modules\Auth\Http\Controllers\Admin;

use App\Providers\RouteServiceProvider;
use Modules\Auth\Http\Controllers\AuthController as Controller;

class AuthController extends Controller
{
    
    public function loginPage(): string
    {
        return 'auth::admin.login.show';
    }

    public function forgotPasswordPage(): string
    {
        return 'auth::admin.forgot-password.show';
    }

    public function resetPasswordPage(): string
    {
        return 'auth::admin.reset-password.show';
    }

    public function changePasswordPage(): string {
        return 'auth::admin.change-password.show';
    }

    public function resetPasswordRedirect(): string {
        return 'admin/auth/login';
    }

    public function homePage(): string
    {
        return RouteServiceProvider::ADMIN;
    }
}
