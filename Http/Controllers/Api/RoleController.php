<?php

namespace Modules\Auth\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Auth\Entities\Role;
use Modules\Auth\Services\RoleService;

class RoleController extends Controller
{

    private RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //
        return $this->roleService->getAll();
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $role = new Role([
            'name'  => $request->get('name')
        ]);

        $permissions = $request->get('permissions', []);

        return response()
            ->json($this->roleService->create($role, $permissions));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $role = $this->roleService->getById($id);

        return response()
            ->json($role);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        //
        $role = new Role([
            'name'  => $request->get('name')
        ]);
        $role->id = $id;

        $permissions = $request->get('permissions', []);

        return response()
            ->json($this->roleService->update($role, $permissions));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
