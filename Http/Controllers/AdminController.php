<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\AdminController as Controller;
use Illuminate\Http\Request;
use Modules\Auth\Http\Requests\CreateRoleRequest;
use Modules\Auth\Http\Requests\EditRoleRequest;
use Modules\Auth\Services\RoleService;
use Modules\User\Services\UserService;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    
    protected UserService $userService;
    protected RoleService $roleService;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    public function getUsers() {
        return view(
            'auth::admin/users/index', 
            [
                'users' => $this->userService->getUsers(),
                'menu' => $this->getMenu()
            ]
        );
    }

    public function getRoles() {
        return view(
            'auth::admin/roles/index',
            [
                'roles' => Role::all(),
                'menu'  => $this->getMenu()
            ]
        );
    }

    public function showCreateUser() {
        return view(
            'auth::admin/users/create',
            [
                'menu'  => $this->getMenu(),
                'roles' => Role::all()
            ]
        );
    }

    public function showCreateRole() {

        return view(
            'auth::admin/roles/create',
            [
                'menu'  => $this->getMenu(),
                'permissions'   => Permission::all()
            ]
        );
    }

    public function showEditRole(int $id) {
        $role = $this->roleService->getById($id);

        return view(
            'auth::admin/roles/edit',
            [
                'menu'          => $this->getMenu(),
                'role'          => $role,
                'permissions'   => Permission::all()
            ]
            );
    }

    public function createRole(CreateRoleRequest $request) {
        $validated = $request->validated();

        $role = $this->roleService->createRole($validated['name'], $validated['permissions']);

        dd($role);
    }

    public function editRole(EditRoleRequest $request) {
        $validated = $request->validated();


        $role = $this->roleService->updateRole($validated['id'], $validated['name'], $validated['permissions']);

        dd($role);
    }

    public function createUser() {

    }

    public function showEditUser(int $id) {
        $user = $this->userService->getUserById($id);
        $roles = $this->roleService->getRoles();

        return view(
            'auth::admin/users/edit',
            [
                'menu'          => $this->getMenu(),
                'user'          => $user,
                'roles'         => $roles
            ]
            );
    }

    public function editUser() {

    }

    public function deleteUser() {

    }

}
