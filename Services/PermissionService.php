<?php

namespace Modules\Auth\Services;

use Modules\Auth\Entities\Permission;

class PermissionService {

    /**
     * Get all the Permissions
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll(): \Illuminate\Database\Eloquent\Collection {
        return Permission::all();
    }

    /**
     * Get Permission by id
     * 
     * @param int $id
     * @return Permission
     */
    public function getById(int $id): Permission {
        return Permission::findOrFail($id);
    }

}