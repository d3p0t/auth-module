<?php

namespace Modules\Auth\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Modules\Auth\Entities\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        if (Schema::hasTable('auth__users'))
        {
            
            User::create([
                'name'      => 'Administrator',
                'username'  => 'admin',
                'password'  => Hash::make('pass'),
                'email'     => 'admin@admin.org',
        
            ]);
            $user = new User([
                'name'      => 'Administrator',
                'username'  => 'admin',
                'email'     => 'admin@admin.org',
                'password'  => Hash::make('pass')
            ]);
            $user->email_verified_at = Carbon::now();
            $user->locale = App::getLocale();

            $user->save();

            $user->assignRole('Super Admin');
        }
    }

}
