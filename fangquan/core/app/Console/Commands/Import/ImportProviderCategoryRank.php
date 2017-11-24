<?php

namespace App\Console\Commands\Import;

use App\Src\Provider\Infra\Eloquent\ProviderRankCategoryModel;
use Illuminate\Console\Command;
use App\Src\Product\Domain\Model\ProductCategoryType;
use Illuminate\Support\Facades\DB;

class ImportProviderCategoryRank extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:rank';

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
        $product_category_types = ProductCategoryType::acceptableEnums();
        $providers = DB::connection('spider')->select("select * from `fortune100_supplier_clean`");

        foreach ($providers as $provider) {
            $category_id = array_search($provider->f_cate, $product_category_types);

            $provider_rank_category_builder = ProviderRankCategoryModel::query();
            $provider_rank_category_builder->where('provider_id', $provider->p_id);
            $provider_rank_category_builder->where('category_id', $category_id);

            if (!$provider_rank_category_builder->first()) {
                $provider_rank_category_model = new ProviderRankCategoryModel();
                $provider_rank_category_model->provider_id = $provider->p_id;
                $provider_rank_category_model->category_id = $category_id;
                $provider_rank_category_model->rank = $provider->m_rank;
                $provider_rank_category_model->save();
                $this->info($provider->m_long_name . ': 添加成功');
                continue;
            }
            $this->error($provider->m_long_name . ': 重复');
        }
        $this->info('结束');
    }
}
