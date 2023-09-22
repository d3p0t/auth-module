<?php

namespace Modules\Auth\Http\Controllers\Admin;

use App\Http\Controllers\AdminController as Controller;
use Modules\Auth\Services\RoleService;
use Modules\Auth\Services\UserService;

class UserController extends Controller
{
    
    protected UserService $userService;
    protected RoleService $roleService;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    public function index() {
        return view(
            'auth::admin/users/index', 
            [
                'users' => $this->userService->getUsers(),
                'menu' => $this->getMenu()
            ]
        );
    }

    public function create() {
        $roles = $this->roleService->all();

        return view(
            'auth::admin/users/create',
            [
                'menu'  => $this->getMenu(),
                'roles' => $roles
            ]
        );
    }


    public function store() {

    }

    public function edit(int $id) {
        $user = $this->userService->getUserById($id);
        $roles = $this->roleService->all();

        return view(
            'auth::admin/users/edit',
            [
                'menu'          => $this->getMenu(),
                'user'          => $user,
                'roles'         => $roles
            ]
            );
    }

    public function update() {

    }

    public function delete(int $id) {

    }

}
