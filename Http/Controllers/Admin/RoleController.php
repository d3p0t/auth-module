<?php

namespace Modules\Auth\Http\Controllers\Admin;

use App\Http\Controllers\AdminController as Controller;
use App\Http\Requests\PageableRequest;
use App\Http\Requests\SortableRequest;
use App\Pageable\PageRequest;
use Gate;
use Modules\Auth\Http\Requests\Admin\CreateRoleRequest;
use Modules\Auth\Http\Requests\Admin\EditRoleRequest;
use Modules\Auth\Services\PermissionService;
use Modules\Auth\Services\RoleService;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

        return view(
            'auth::admin/roles/index',
            [
                'roles' => $this->roleService->searchRoles(
                    $searchCriteria,
                    PageRequest::fromRequest($pageableRequest, $sortableRequest)
                )
            ]
        );
    }


    public function create() {
        return view(
            'auth::admin/roles/create',
            [
                'permissions'   => $this->permissionService->getPermissions()
            ]
        );
    }

    public function edit(int $id) {
        Gate::authorize('update', $this->roleService->getById($id));

        return view(
            'auth::admin/roles/edit',
            [
                'role'          => $this->roleService->getById($id),
                'permissions'   => $this->permissionService->getPermissions()
            ]
            );
    }

    public function store(CreateRoleRequest $request) {
        $role = $this->roleService->createRole(
            $request->toRole(),
            $request->toPermissions()
        );

        return redirect()
            ->route('auth::admin.roles.index')
            ->with('status', __('auth::roles.action.created', ['name' => $role->name]));
    }

    public function update(EditRoleRequest $request) {

        $role = $this->roleService->updateRole(
            $request->toRole(),
            $request->toPermissions()
    
        );

        return redirect()
            ->route('auth::admin.roles.index')
            ->with('status', __('auth::roles.actions.updated', ['name' => $role->name]));
    }

    public function delete(int $id) {
        if ($this->roleService->deleteRole($id)) {
            return redirect()
                ->route('auth::admin.roles.index')
                ->with('status', __('auth::roles.actions.deleted'));
        }
        throw new HttpException(500, 'Could not delete role');
    }

}
