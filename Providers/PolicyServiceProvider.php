<?php

namespace Modules\Auth\Providers;

use Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Modules\Auth\Entities\Role;
use Modules\Auth\Policies\RolePolicy;

class PolicyServiceProvider extends ServiceProvider {

    protected $policies = [
        Role::class => RolePolicy::class,
    ];

    public function boot() {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
    }

}