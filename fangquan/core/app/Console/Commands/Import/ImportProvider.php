<?php

namespace App\Console\Commands\Import;

use App\Service\QiNiu\QiNiuService;
use App\Src\Product\Domain\Model\ProductCategoryType;
use App\Src\Provider\Domain\Model\OperationModelType;
use App\Src\Provider\Domain\Model\ProviderAdType;
use App\Src\Provider\Domain\Model\ProviderImageType;
use App\Src\Provider\Domain\Model\ProviderStatus;
use App\Src\Provider\Infra\Eloquent\ProviderModel;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Src\Surport\Domain\Model\CityEntity;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Infra\Repository\CityRepository;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportProvider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:provider';

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
        //id1000以下为测试数据
        $product_category_type = ProductCategoryType::acceptableEnums();
        $provider_repository = new ProviderRepository();
        $province_repository = new ProvinceRepository();
        $qi_niu_service = new QiNiuService();
        $city_repository = new CityRepository();
        $providers = DB::connection('spider')->select("select * from `fortune100_supplier_info_cleanCate`");

        foreach ($providers as $provider) {
            $provider_model = ProviderModel::find($provider->id);
            if (!isset($provider_model)) {
                $provider_model = new ProviderModel();
            }
            $provider_model->id = $provider->id;
            $provider_model->company_name = $provider->long_name;
            $provider_model->brand_name = $provider->sort_name;
            $address = explode(' ', $provider->address);
            /** @var ProvinceEntity $province_entity */
            $province_entity = $province_repository->getProvinceByName(mb_substr($address[0], 0, 2, 'utf-8'));
            if (isset($province_entity)) {
                $provider_model->province_id = $province_entity->id;
                /** @var CityEntity $city_entity */
                $city_entity = $city_repository->getCityByProvinceIdAndName($province_entity->id, $address[1]);
                if (isset($city_entity)) {
                    $provider_model->city_id = $city_entity->id;
                }
            }
            $provider_model->operation_address = $provider->address;
            $provider_model->service_telphone = $provider->contact_phone;
            $provider_model->website = $provider->company_web;

            $provider_model->founding_time = mb_substr($provider->build_time, 0, 4);
            $provider_model->operation_mode = OperationModelType::MANUFACTURER;
            $provider_model->summary = $provider->basic_desc;
            $provider_model->rank = $provider->id;
            $provider_model->is_ad = ProviderAdType::NO;

            $provider_pictures = [];
            $file = download($provider->logo, 'developer');
            $image_result = $qi_niu_service->upload($file);
            if (is_array($image_result)) {
                $provider_pictures = [0 => ['type' => ProviderImageType::LOGO, 'image_id' => $image_result['id']]];
            } else {
                $this->error($provider->long_name . ': 上传图片失败');
            }
            unlink($file);
            $provider_model->project_count = 0;
            $provider_model->favorite_count = 0;
            $provider_model->patent_count = 0;
            $provider_model->product_count = 0;
            $provider_model->score_scale = 0;
            $provider_model->score_qualification = 0;
            $provider_model->score_credit = 0;
            $provider_model->score_innovation = 0;
            $provider_model->score_service = 0;
            $provider_model->integrity = 30;
            $provider_model->produce_province_id = 0;
            $provider_model->produce_city_id = 0;
            $provider_model->produce_address = '';
            $provider_model->telphone = '';
            $provider_model->fax = '';
            $provider_model->turnover = 0;
            $provider_model->registered_capital = 0;
            $provider_model->worker_count = 0;
            $provider_model->corp = $provider->leader;
            $provider_model->contact = '';
            $provider_model->status = ProviderStatus::YES_CERTIFIED;
            $provider_model->save();
            $provider_model->provider_pictures()->createMany($provider_pictures);
            $this->info($provider->long_name . ': 导入信息成功');
        }
        $this->info('结束！');
    }
}
