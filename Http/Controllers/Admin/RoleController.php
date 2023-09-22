<?php

namespace Modules\Auth\Http\Controllers\Admin;

use App\Http\Controllers\AdminController as Controller;
use App\Http\Requests\PageableRequest;
use App\Http\Requests\SortableRequest;
use App\Pageable\PageRequest;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Requests\CreateRoleRequest;
use Modules\Auth\Http\Requests\EditRoleRequest;
use Modules\Auth\Services\PermissionService;
use Modules\Auth\Services\RoleService;

class RoleController extends Controller
{
    
    protected RoleService $roleService;
    protected PermissionService $permissionService;

    public function __construct(RoleService $roleService, PermissionService $permissionService)
    {
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;

    }

    public function index(
        PageableRequest $pageableRequest,
        SortableRequest $sortableRequest
    ) {
        $searchCriteria = [];

        $pageable = $this->roleService->searchRoles(
            $searchCriteria,
            PageRequest::fromRequest($pageableRequest, $sortableRequest)
        );

        return view(
            'auth::admin/roles/index',
            [
                'roles' => $pageable,
                'menu'  => $this->getMenu()
            ]
        );
    }


    public function create() {
        $permissions = $this->permissionService->getPermissions();

        return view(
            'auth::admin/roles/create',
            [
                'menu'  => $this->getMenu(),
                'permissions'   => $permissions
            ]
        );
    }

    public function edit(int $id) {
        return view(
            'auth::admin/roles/edit',
            [
                'menu'          => $this->getMenu(),
                'role'          => $this->roleService->getById($id),
                'permissions'   => $this->permissionService->getPermissions()
            ]
            );
    }

    public function store(CreateRoleRequest $request) {
        $validated = $request->validated();

        $role = $this->roleService->createRole($validated['name'], $validated['permissions']);

    }

    public function update(EditRoleRequest $request) {
        $validated = $request->validated();

        $role = $this->roleService->updateRole(
            $validated['id'], 
            $validated['name'], 
            $validated['permissions']
        );

        return redirect('/auth/admin/roles')
            ->with('status', 'Role updated');

    }

    public function delete(int $id) {

    }

}
