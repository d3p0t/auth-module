<?php

namespace Modules\Auth\Services;

use App\Models\User;

class UserService
{
    /**
     * Get User By Id
     * @param int $id
     */
    public function getUserById(int $id): User {
        return User::findOrFail($id);
    }

    /**
     * Get User by Username
     * @param String $username
     */
    public function getUserByUsername(String $username): User {
        return User::where(['username' => $username])->first();
    }

    /**
     * Create User
     * @param User $user
     */
    public function createUser(User $user): User {
        $user->save();

        return $user;
    }

    /**
     * Update User
     * @param User $user
     */
    public function updateUser(User $user): User {
        $user->save();

        return $user;
    }

    /**
     * Delete User
     * @param int $id
     */
    public function deleteUser(int $id): void {
        $this->getUserById($id)->delete();
    }

    /**
     * Get all the users
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsers(): \Illuminate\Database\Eloquent\Collection {
        return User::all();
    }
    
}


