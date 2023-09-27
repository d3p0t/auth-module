<?php

namespace Modules\Auth\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $permissions = [
            'auth',
            'view roles',
            'create roles',
            'update roles',
            'delete roles',
            'view users',
            'create users',
            'update users',
            'delete users',
        ];
        
        $tableNames = config('permission.table_names');

        if (Schema::hasTable($tableNames['permissions']))
        {
            
            foreach ($permissions as $permission) {
                DB::table($tableNames['permissions'])->insert([
                    'name'          => $permission,
                    'module'        => 'auth',
                    'guard_name'    => 'web',
                    'created_at'    => Carbon::now()->format('Y-m-d H:i:s')
                ]);
            }

        }

    }
}
