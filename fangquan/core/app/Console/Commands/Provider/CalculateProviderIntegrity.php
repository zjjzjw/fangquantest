<?php

namespace App\Console\Commands\Provider;

use App\Service\Provider\ProviderService;
use App\Service\Push\PushService;
use App\Src\Provider\Infra\Eloquent\ProviderModel;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Console\Command;

class CalculateProviderIntegrity extends Command
{
    use DispatchesJobs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:provider:integrity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $provider_service = new ProviderService();
        $builder = ProviderModel::query();
        $models = $builder->get();
        foreach ($models as $model) {
            $score = $provider_service->calculateIntegrity($model->id);
            $model->integrity = $score;
            $model->save();
            $this->info($model->id, '计算完成');
        }
    }
}
