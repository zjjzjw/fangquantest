<?php

namespace App\Console;

use App\Console\Commands\ImportDeveloper;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        \App\Console\Commands\TestJob::class,
        \App\Console\Commands\Provider\CalculateProviderIntegrity::class,
        \App\Console\Commands\Import\ImportDeveloper::class,
        \App\Console\Commands\Import\ImportProvider::class,
        \App\Console\Commands\Import\ImportProviderCategoryRank::class,
        \App\Console\Commands\Import\ImportProviderNews::class,
        \App\Console\Commands\Import\ImportMainCategory::class,
        \App\Console\Commands\Import\ImportProviderProduct::class,
        \App\Console\Commands\Import\ImportProviderBusiness::class,
        \App\Console\Commands\Import\ImportProviderServiceNetwork::class,
        \App\Console\Commands\Provider\CalculateProviderScore::class,
        \App\Console\Commands\Update\UpdateRegisteredCapital::class,
        \App\Console\Commands\Import\ImportDeveloperProject::class,
        \App\Console\Commands\Import\ImportDeveloperProjectContact::class,
        \App\Console\Commands\Exhibition\ImportUserAnswer::class,
        \App\Console\Commands\Import\ImportDeveloperProjectCategory::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->command('test:job')->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
