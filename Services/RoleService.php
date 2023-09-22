<?php

namespace Modules\Auth\Services;

use App\Pageable\Pageable;
use App\Pageable\PageRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;

class RoleService {

    /**
     * Get all the Roles
     * @return Collection
     */
    public function all(): Collection {
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
    public function searchRoles(Array $searchCriteria, PageRequest $pageRequest): Pageable {
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
        return Role::findOrFail($id);
    }

    /**
     * @param String $name
     * @param Array $permissions
     * 
     * @return Role
     */
    public function createRole(String $name, Array $permissions): Role {
        $role = new Role([
            'name'  => $name
        ]);

        $role->save();

        $role->syncPermissions($permissions);

        return $role;
    }

    /**
     * @param int $id
     * @param String $name
     * @param Array $permissions
     * 
     * @return Role
     */
    public function updateRole(int $id, String $name, Array $permissions): Role {
        $role = $this->getById($id);

        $role->name = $name;

        $role->save();
        $role->syncPermissions($permissions);

        return $role;
    }

}