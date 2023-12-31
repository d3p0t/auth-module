<?php

namespace Modules\Auth\Http\Controllers\Admin;

use App\Http\Controllers\AdminController as Controller;
use App\Http\Requests\PageableRequest;
use App\Http\Requests\SortableRequest;
use App\Pageable\PageRequest;
use Modules\Auth\Http\Requests\Admin\CreateUserRequest;
use Modules\Auth\Http\Requests\Admin\EditUserRequest;

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

    public function index(
        PageableRequest $pageableRequest,
        SortableRequest $sortableRequest
    ) {
        return view(
            'auth::admin/users/index',
            [
                'users' => $this->userService->search(
                    [],
                    PageRequest::fromRequest($pageableRequest, $sortableRequest)
                )
            ]
        );
    }

    public function create() {
        return view(
            'auth::admin/users/create',
            [
                'roles' => $this->roleService->getAll()
            ]
        );
    }

    public function store(CreateUserRequest $request) {
        $user = $this->userService->create(
            $request->toModel(),
            $request->role()
        );

        return redirect('/admin/auth/users')
            ->with('status', __('auth::users.actions.created', ['username' => $user->username]));
    }

    public function edit(int $id) {
        return view(
            'auth::admin/users/edit',
            [
                'user'          => $this->userService->getById($id),
                'roles'         => $this->roleService->getAll()
            ]
        );
    }

    public function update(EditUserRequest $request) {
        $user = $this->userService->update(
            $request->toUser(),
            $request->role()
        );

        return redirect('/admin/auth/users')
            ->with('status', __('auth::users.actions.updated', ['username' => $user->username]));
    }

    public function delete(int $id) {
        if (!$this->userService->delete($id)) {
            return redirect('/admin/auth/users')
                ->withErrors('status', 'Cannot delete user');
        }

        return redirect('/admin/auth/users')
            ->with('status', __('auth::users.action.deleted'));
    }

}
