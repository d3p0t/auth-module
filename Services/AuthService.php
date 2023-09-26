<?php

namespace Modules\Auth\Services;

use Modules\Auth\Entities\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthService {

    private UserService $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

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

    public function authenticate(String $username, String $password) {
        $user = $this->userService->getByUsername($username);

        if (!$user) {
            throw new HttpException(401, "Cannot find user");
        }

        if (!Hash::check($password, $user->password)) {
            throw new HttpException(401, "Invalid password");
        }

        return $user->createToken('User Token');
    }
}

