<?php

namespace Modules\Auth\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService {

    /**
     * @param String $username
     * @param String $password
     * @param bool $remember
     * 
     * @return bool
     */
    public function login(String $username, String $password, bool $remember = false): bool
    {
        return Auth::attempt(
            [
                'username' => $username,
                'password'  => $password
            ],
            $remember
        );
    }

    /**
     * @return bool
     */
    public function logout(): bool
    {
        Auth::logout();

        return true;
    }

    /**
     * @param String $username
     * @param String password
     * 
     * @return User
     */
    public function register(String $username, String $password): User
    {
        $user = new User([
            'username'      => $username,
            'password'      => Hash::make($password)
        ]);

        $user->save();

        return $user;
    }

    /**
     * @return User | null
     */
    public function getCurrentUser(): User | null
    {
        return Auth::user();
    }
}