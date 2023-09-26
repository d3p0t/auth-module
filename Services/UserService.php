<?php

namespace Modules\Auth\Services;

use App\Exceptions\ModelValidationException;
use D3p0t\Core\Pageable\Pageable;
use D3p0t\Core\Pageable\PageRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\Auth\Entities\User;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserService
{

    private RoleService $roleService;

    public function __construct(
        RoleService $roleService
    )
    {
        $this->roleService = $roleService;
    }

    /** 
     * Search Users
     * 
     * @param Array $searchCriteria
     * @param PageRequest $pageRequest
     * 
     * @return LengthAwarePaginator
     */
    public function search(Array $searchCriteria, PageRequest $pageRequest): Pageable {
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
    public function getById(int $id): User {
        return User::findOrFail($id);
    }

    /**
     * Get User by Username
     * 
     * @param String $username
     * 
     * @return User|null
     */
    public function getByUsername(String $username): User|null {
        return User::where(['username' => $username])->first();
    }

    /**
     * Create a User
     * 
     * @param User $user
     * @param int $roleId
     * 
     * @throws ModelValidationException
     * @throws HttpException
     * 
     * @param User $user
     */
    public function create(User $user, int $roleId): User {
        $user->password = Hash::make($user->password);

        try {
            if ($user->save()) {
                $user->assignRole($this->roleService->getById($roleId)->name);
            }
            throw new HttpException(500, 'Cannot create user');
        } catch (ValidationException $e) {
            throw new ModelValidationException($e, $user);
        }

        return $user;
    }

    /**
     * Update User
     * @param User $user
     * 
     * @throws ModelValidationException 
     * @throws HttpException
     * @return User
     */
    public function update(User $user, int $roleId): User {
        try {
            if  ($this->getById($user->id)->update([
                'name'      => $user->name,
                'username'  => $user->username,
                'email'     => $user->email
            ])) {
                
                dd($user->syncRoles([$this->roleService->getById($roleId)->name]));

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
    public function delete(int $id): bool {
        if (Auth::id() === $id) {
            throw new HttpException(500, 'Cannot delete current user');
        }

        $user = $this->getById($id);
        
        return $user->delete();
    }

    /**
     * Get all the users
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll(): \Illuminate\Database\Eloquent\Collection {
        return User::all();
    }
    
}


