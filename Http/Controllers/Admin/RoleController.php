<?php

namespace Modules\Auth\Http\Controllers\Admin;

use App\Http\Controllers\AdminController as Controller;
use D3p0t\Core\Pageable\PageRequest;
use D3p0t\Core\Pageable\Requests\PageableRequest;
use D3p0t\Core\Pageable\Requests\SortableRequest;
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
                'roles' => $this->roleService->search(
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
                'permissions'   => $this->permissionService->getAll()
            ]
        );
    }

    public function edit(int $id) {
        Gate::authorize('update', $this->roleService->getById($id));

        return view(
            'auth::admin/roles/edit',
            [
                'role'          => $this->roleService->getById($id),
                'permissions'   => $this->permissionService->getAll()
            ]
        );
    }

    public function store(CreateRoleRequest $request) {
        $role = $this->roleService->create(
            $request->toModel(),
            $request->permissions()
        );

        return redirect()
            ->route('auth::admin.roles.index')
            ->with('status', __('auth::roles.action.created', ['name' => $role->name]));
    }

    public function update(EditRoleRequest $request) {
        $role = $this->roleService->update(
            $request->toModel(),
            $request->permissions()
        );

        return redirect()
            ->route('auth::admin.roles.index')
            ->with('status', __('auth::roles.actions.updated', ['name' => $role->name]));
    }

    public function delete(int $id) {
        if ($this->roleService->delete($id)) {
            return redirect()
                ->route('auth::admin.roles.index')
                ->with('status', __('auth::roles.actions.deleted'));
        }
        throw new HttpException(500, 'Could not delete role');
    }

}
