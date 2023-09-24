<?php

namespace Modules\Auth\Services;

use App\Exceptions\ModelValidationException;
use App\Pageable\Pageable;
use App\Pageable\PageRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\Auth\Entities\User;
use Modules\Auth\Entities\Role;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserService
{

    /** 
     * Search Users
     * 
     * @param Array $searchCriteria
     * @param PageRequest $pageRequest
     * 
     * @return LengthAwarePaginator
     */
    public function searchUsers(Array $searchCriteria, PageRequest $pageRequest): Pageable {
        $query = User::where(function($q) use ($searchCriteria) {
            if (array_key_exists('username', $searchCriteria)) {
                $q->where('username', 'LIKE', '%' . $searchCriteria['username'] . '%');
            } 
            if (array_key_exists('email', $searchCriteria)) {
                $q->where('email', 'LIKE', '%' . $searchCriteria['email'] . '%');
            }
            return $q;
        });

        if ($pageRequest->sortRequest()->sortBy() === 'role') {
            $query = $query->orderBy(function($q) {
                return $q->roles[0]->name;
            });
        } else {
            $query = $query->orderBy($pageRequest->sortRequest()->sortBy(), $pageRequest->sortRequest()->sortDirection());
        }

        $users = $query->get();

        $paginator = new LengthAwarePaginator(
            $users->slice($pageRequest->perPage() * ($pageRequest->pageNumber()), $pageRequest->perPage()),
            $users->count(),
            $pageRequest->perPage(),
            $pageRequest->pageNumber()
        );
            
        return new Pageable($pageRequest, $paginator);
    }

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
    public function createUser(User $user, Role $role): User {
        $user->password = Hash::make($user->password);

        try {
            if ($user->save()) {
                $user->assignRole($role->name);
            }
        } catch (ValidationException $e) {
            throw new ModelValidationException($e, $user);
        }

        return $user;
    }

    /**
     * Update User
     * @param User $user
     */
    public function updateUser(User $user, Role $role): User {
        try {
            if  ($this->getUserById($user->id)->update([
                'name'      => $user->name,
                'username'  => $user->username,
                'email'     => $user->email
            ])) {
                
                dd($user->syncRoles([$role->name]));

                return $user;
            }

            throw new HttpException('Error updating user');
        } catch (ValidationException $e) {
            throw new ModelValidationException($e, $user);
        }

        throw new HttpException(500, 'Could not update user');
    }

    /**
     * Delete User
     * @param int $id
     */
    public function deleteUser(int $id): bool {
        if (Auth::id() === $id) {
            throw new HttpException(500, 'Cannot delete current user');
        }

        $user = $this->getUserById($id);
        
        return $user->delete();
    }

    /**
     * Get all the users
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsers(): \Illuminate\Database\Eloquent\Collection {
        return User::all();
    }
    
}


