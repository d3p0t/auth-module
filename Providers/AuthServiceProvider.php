<?php

namespace Modules\Auth\Providers;

use Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Modules\Auth\Entities\Role;
use Modules\Auth\Policies\RolePolicy;

class AuthServiceProvider extends ServiceProvider {

    protected $policies = [
        Role::class => RolePolicy::class,
    ];

    public function boot() {
     //   Passport::loadKeysFrom(__DIR__.'/../secrets/oauth');

        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
    }

}