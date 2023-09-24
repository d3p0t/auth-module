<?php

namespace Modules\Auth\Http\Controllers\Admin;

use Modules\Auth\Http\Controllers\AuthController as Controller;

class AuthController extends Controller
{
    
    public function loginPage(): string
    {
        return 'auth::admin.auth.login';
    }

    public function forgotPasswordPage(): string
    {
        return 'auth::admin.auth.forgot-password';
    }

    public function resetPasswordPage(): string
    {
        return 'auth::admin.auth.reset-password';
    }

    public function resetPasswordRedirect(): string {
        return 'admin/auth/login';
    }

}
