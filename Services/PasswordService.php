<?php

namespace Modules\Auth\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Modules\Auth\Entities\User;
use Illuminate\Auth\Events\PasswordReset;

class PasswordService {

    /**
     * Send a Reset Password link to the provided Email
     * 
     * @param String $email
     * @return String
     */
    public function sendResetLink(String $email): string { 
        return Password::sendResetLink(
            $email
        );
     
    }

    /**
     * Checks the reset password token
     * 
     * @param String $token
     * @param String $email
     * 
     * @return bool
     */
    public function checkResetPasswordToken(String $token, String $email): bool {
        $password_resets = DB::table('password_reset_tokens')->where('email', $email)->first();

        if ($password_resets &&  Hash::check($token, $password_resets->token)) {
            $createdAt = Carbon::parse($password_resets->created_at);
            if (!Carbon::now()->greaterThan($createdAt->addMinutes(config('auth.passwords.users.expire')))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Resets the password for a user
     * 
     * @param String $token
     * @param String $email
     * @param String $password
     * @param String $passwordConfirmation
     */
    public function resetPassword(String $token, String $email, String $password, String $passwordConfirmation): String {

        return Password::reset([
            'token'                 => $token,
            'email'                 => $email,
            'password'              => $password,
            'password_confirmation' => $passwordConfirmation
        ], function(User $user) {

            $user->setRememberToken(Str::random(60));
            $user->save();

            event(new PasswordReset($user));
        });
    }

    public function changePassword(User $user, String $password): bool {
        $user->password = Hash::make($password);

        return $user->save();
    }
}
