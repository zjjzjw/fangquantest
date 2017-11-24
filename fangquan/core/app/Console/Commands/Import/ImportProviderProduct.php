<?php

namespace App\Console\Commands\Import;

use App\Mobi\Service\Provider\ProviderProductMobiService;
use App\Service\QiNiu\QiNiuService;
use App\Src\Provider\Domain\Model\ProviderNewsStatus;
use App\Src\Provider\Infra\Eloquent\ProviderNewsModel;
use App\Src\Provider\Infra\Eloquent\ProviderProductModel;
use App\Src\Provider\Infra\Eloquent\ProviderProductPictureModel;
use App\Src\Provider\Infra\Eloquent\ProviderProjectPictureModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportProviderProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:provider:product';

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
        $qi_niu_service = new QiNiuService();
        $providers = DB::connection('spider')->select("select * from `fortune100_supplier_info_cleanCate`");
        foreach ($providers as $provider) {
            $content = $provider->product_info;
            $products = \GuzzleHttp\json_decode($content, true);
            foreach ($products as $product) {
                $provider_product_model = new ProviderProductModel();
                $provider_product_model->provider_id = $provider->id;
                $provider_product_model->price_low = str_replace('￥', '', $product['price']);
                $provider_product_model->price_high = str_replace('￥', '', $product['price']);
                $provider_product_model->name = $product['product'];
                $provider_product_model->save();
                $file = download($product['image'], 'provider');
                $image_result = $qi_niu_service->upload($file);

                if (is_array($image_result)) {
                    $provider_product_picture_model = new ProviderProductPictureModel();
                    $provider_product_picture_model->provider_product_id = $provider_product_model->id;
                    $provider_product_picture_model->image_id = $image_result['id'];
                    $provider_product_picture_model->save();
                }
                unlink($file);
            }
            $this->info($provider->long_name . '导入完成');
        }
        $this->info('结束');
    }

}
