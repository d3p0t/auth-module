<?php

namespace Modules\Auth\Services;

use App\Exceptions\ModelValidationException;
use D3p0t\Core\Pageable\Pageable;
use D3p0t\Core\Pageable\PageRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;
use Modules\Auth\Entities\Role;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RoleService {

    /**
     * Get all the Roles
     * @return Collection
     */
    public function getAll(): Collection {
        return Role::all();
    }
     
    /** 
     * Search Roles
     * 
     * @param Array $searchCriteria
     * @param PageRequest $pageRequest
     * 
     * @return LengthAwarePaginator
     */
    public function search(Array $searchCriteria, PageRequest $pageRequest): Pageable {
        $query = Role::where(function($q) use ($searchCriteria) {
            if (array_key_exists('name', $searchCriteria)) {
                $q->where('name', 'LIKE', '%' . $searchCriteria['name'] . '%');
            } 
            return $q;
        });

        $query = $query->orderBy($pageRequest->sortRequest()->sortBy(), $pageRequest->sortRequest()->sortDirection());

        $roles = $query->get();


        $paginator = new LengthAwarePaginator(
            $roles->slice($pageRequest->perPage() * ($pageRequest->pageNumber()), $pageRequest->perPage()),
            $roles->count(),
            $pageRequest->perPage(),
            $pageRequest->pageNumber()
        );
            
        return new Pageable($pageRequest, $paginator);
    }

    /**
     * Get role by id
     * 
     * @param int $id
     * @return Role
     */
    public function getById(int $id): Role {
        return Role::with('permissions')->findOrFail($id);
    }

    /**
     * @param String $name
     * @param Array $permissions
     * 
     * @return Role
     */
    public function create(Role $role, Array $permissions): Role {
        try {
            $role->guard_name = 'web';
            $role->is_internal = false;
            if ($role->save()) {
                $role->syncPermissions($permissions);
                return $role;
            }
            throw new HttpException(500, "Error saving role");
        } catch (ValidationException $e) {
            throw new ModelValidationException($e, $role);
        }
        throw new HttpException(500, 'Could not create role');
    }

    /**
     * @param Role $role
     * @param Array $permissions
     * 
     * @return Role
     */
    public function update(Role $role, Array $permissions): Role {
        try {
            if ($this->getById($role->id)->update([
                'name'  => $role->name
            ])) {
                $this->getById($role->id)->syncPermissions($permissions);
                return $role;
            }
            throw new HttpException(500, 'Could not update role');

        } catch (ValidationException $e) {
            throw new ModelValidationException($e, $role);
        }
        throw new HttpException(500, 'Could not update role');

    }

    /**
     * @param int $id
     * 
     * @return bool
     */
    public function delete(int $id): bool {
        $role = $this->getById($id);

        if (!$role->users->isEmpty()) {
            throw new HttpException(500, 'Cannot delete role that is assigned to users');
        }

        return $role->delete();
    }

}