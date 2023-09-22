<?php

namespace Modules\Auth\Services;

use Spatie\Permission\Models\Permission;

class PermissionService {

    /**
     * Get all the Permissions
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPermissions(): \Illuminate\Database\Eloquent\Collection {
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