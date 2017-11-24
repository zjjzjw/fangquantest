<?php

namespace App\Admin\Providers;

use App\Admin\Src\Auth\UserCenterService;
use App\Admin\Src\Auth\UserCenterUserProvider;
use Illuminate\Support\ServiceProvider;
use Auth;


class UserCenterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $user_center_service = new UserCenterService();
        $model = config('auth.providers.users.model');
        Auth::provider('user_center', function ($app) use ($user_center_service, $model) {
            return new UserCenterUserProvider($user_center_service, $model, $app);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
