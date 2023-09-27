<?php

namespace Modules\Auth\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();


        $tableNames = config('permission.table_names');

        if (Schema::hasTable($tableNames['roles']))
        {
            
            DB::table($tableNames['roles'])->insert([
                'name'          => 'Super Admin',
                'guard_name'    => 'web',
                'is_internal'   => true,
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }

}
