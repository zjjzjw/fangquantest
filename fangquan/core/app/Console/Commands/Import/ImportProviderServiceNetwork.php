<?php

namespace App\Console\Commands\Import;

use App\Src\Provider\Domain\Model\ProviderServiceNetworkStatus;
use App\Src\Provider\Infra\Eloquent\ProviderServiceNetworkModel;
use App\Src\Surport\Domain\Model\CityEntity;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Infra\Repository\CityRepository;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportProviderServiceNetwork extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:provider:service:network';

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
        $province_repository = new ProvinceRepository();
        $city_repository = new CityRepository();
        $provider_service_networks = DB::connection('spider')->select("select * from `fq_provider_service_network`");
        foreach ($provider_service_networks as $provider_service_network) {
            $provider_service_network_model = new ProviderServiceNetworkModel();
            /** @var ProvinceEntity $province_entity */
            $province_entity = $province_repository->getProvinceByName(mb_substr($provider_service_network->province_name, 0, 2, 'utf-8'));
            if (isset($province_entity)) {
                $provider_service_network_model->province_id = $province_entity->id;
                /** @var CityEntity $city_entity */
                $city_entity = $city_repository->getCityByProvinceIdAndName($province_entity->id, $provider_service_network->city_name);
                if (isset($city_entity)) {
                    $provider_service_network_model->city_id = $city_entity->id;
                }
            }
            $provider_service_network_model->provider_id = $provider_service_network->provider_id;
            $provider_service_network_model->name = $provider_service_network->shop_name;
            $provider_service_network_model->telphone = $provider_service_network->telephone;
            $provider_service_network_model->contact = $provider_service_network->contact;
            $provider_service_network_model->address = $provider_service_network->address;
            $provider_service_network_model->worker_count = $provider_service_network->work_count;
            $provider_service_network_model->status = ProviderServiceNetworkStatus::STATUS_PASS;
            $provider_service_network_model->save();

            $this->info($provider_service_network->id . '||' . $provider_service_network->provider_id . '导入完成');
        }
        $this->info('结束！');
    }
}
