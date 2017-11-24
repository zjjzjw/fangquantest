<?php

namespace App\Admin\Providers;

use App\Admin\Composers\PageComposer;
use Illuminate\Support\ServiceProvider;

class PageServiceProvider extends ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        //if (\Cookie::get('APP_DEBUG') == "true" && request()->getClientIp() == env('HOST_IP')) {
        //}
        performance()->startRecordQueries();
        view()->composer('pages.*', PageComposer::class);
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
    }

}