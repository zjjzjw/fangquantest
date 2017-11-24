<?php

namespace App\Console\Commands\Import;

use App\Src\Provider\Infra\Eloquent\ProviderMainCategoryModel;
use App\Src\Provider\Infra\Eloquent\ProviderModel;
use App\Src\Provider\Infra\Eloquent\ProviderRankCategoryModel;
use Illuminate\Console\Command;

class ImportMainCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:main:category';

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
        $porviders = ProviderModel::all();

        foreach ($porviders as $provider) {
            $builder = ProviderRankCategoryModel::query();
            $builder->where('provider_id', $provider->id);
            $rank_models = $builder->get();
            foreach ($rank_models as $rank_model) {
                $provider_main_category_model = new ProviderMainCategoryModel();
                $provider_main_category_model->provider_id = $rank_model->provider_id;
                $provider_main_category_model->product_category_id = $rank_model->category_id;
                $provider_main_category_model->save();
            }
            $this->info($provider->brand_name . '导入完成！');
        }
        $this->info('导入结束');
    }
}
