<?php

namespace App\Console\Commands\Update;

use App\Src\Provider\Infra\Eloquent\ProviderMainCategoryModel;
use App\Src\Provider\Infra\Eloquent\ProviderModel;
use App\Src\Provider\Infra\Eloquent\ProviderRankCategoryModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateRegisteredCapital extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:registered:capital';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $providers = DB::connection('spider')->select("select * from `fq_supplier_info_lack`");
        foreach ($providers as $provider) {
            $provider_model = ProviderModel::find($provider->p_id);

            if (isset($provider_model)) {
                if ($provider->resgin_number != 'None') {
                    $provider_model->registered_capital = $provider->resgin_number;
                    $provider_model->registered_capital_unit = $provider->resgin_unit;
                    $provider_model->save();
                }
                $this->info($provider_model->id . '更新完成！');
            }
        }
    }
}
