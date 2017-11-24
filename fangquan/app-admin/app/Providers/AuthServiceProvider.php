<?php

namespace App\Admin\Providers;

use App\Admin\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        $config_permissions = config('permissions');

        $collect_names = collect(array_keys($config_permissions));
        $collect_names->each(function ($item) {
            Gate::define($item, function ($user) use ($item) {
                /** @var User $user */
                return $user->hasPermission($item);
            });
        });
    }
}
