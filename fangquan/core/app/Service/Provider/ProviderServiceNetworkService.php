<?php

namespace App\Service\Provider;


use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderServiceNetworkEntity;
use App\Src\Provider\Domain\Model\ProviderServiceNetworkSpecification;
use App\Src\Provider\Domain\Model\ProviderServiceNetworkStatus;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Src\Provider\Infra\Repository\ProviderServiceNetworkRepository;
use App\Src\Surport\Domain\Model\CityEntity;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Infra\Repository\CityRepository;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProviderServiceNetworkService
{
    /**
     * @param ProviderServiceNetworkSpecification $spec
     * @param int                                 $per_page
     * @return array
     */
    public function getProviderServiceNetworkList(ProviderServiceNetworkSpecification $spec, $per_page = 20)
    {
        $data = [];
        $provider_service_network_repository = new ProviderServiceNetworkRepository();
        $paginate = $provider_service_network_repository->search($spec, $per_page);
        $provider_service_network_status = ProviderServiceNetworkStatus::acceptableEnums();
        $items = [];

        $province_repository = new ProvinceRepository();
        $city_repository = new CityRepository();
        /**
         * @var int                          $key
         * @var ProviderServiceNetworkEntity $provider_service_network_entity
         * @var LengthAwarePaginator         $paginate
         */
        foreach ($paginate as $key => $provider_service_network_entity) {
            $item = $provider_service_network_entity->toArray();
            /** @var CityEntity $city_entity */
            $city_entity = $city_repository->fetch($provider_service_network_entity->city_id);
            if (isset($city_entity)) {
                $item['city'] = $city_entity->toArray();
            }
            $province_entity = $province_repository->fetch($provider_service_network_entity->province_id);
            if (isset($province_entity)) {
                $item['province'] = $province_entity->toArray();
            }
            $provider_repository = new ProviderRepository();
            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($provider_service_network_entity->provider_id);
            if (isset($provider_entity)) {
                $item['provider'] = $provider_entity->toArray();
            }
            $item['status_name'] = $provider_service_network_status[$provider_service_network_entity->status];
            $items[] = $item;
        }

        $data['paginate'] = $paginate;
        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();

        return $data;
    }

    public function getProviderServiceNetworkInfo($id)
    {
        $data = [];
        $provider_service_network_repository = new ProviderServiceNetworkRepository();
        $provider_repository = new ProviderRepository();

        /** @var ProviderServiceNetworkEntity $provider_service_network_entity */
        $provider_service_network_entity = $provider_service_network_repository->fetch($id);
        if (isset($provider_service_network_entity)) {
            $data = $provider_service_network_entity->toArray();
            $provider_entity = $provider_repository->fetch($data['provider_id']);
            if (isset($provider_entity)) {
                $data['company_name'] = $provider_entity->company_name;
                $data['brand_name'] = $provider_entity->brand_name;
            }
        }

        return $data;
    }

    public function getProviderServiceNetworkByProviderId($provider_id, $status = ProviderServiceNetworkStatus::STATUS_PASS)
    {
        $items = [];
        $provider_service_network_repository = new ProviderServiceNetworkRepository();
        $province_repository = new ProvinceRepository();
        $city_repository = new CityRepository();
        $provider_service_network_entities = $provider_service_network_repository->getProviderServiceNetworkByProviderIdAndStatus($provider_id, $status);
        /** @var ProviderServiceNetworkEntity $provider_service_network_entity */
        foreach ($provider_service_network_entities as $provider_service_network_entity) {
            $item = [];
            $item = $provider_service_network_entity->toArray();
            /** @var CityEntity $city_entity */
            $city_entity = $city_repository->fetch($provider_service_network_entity->city_id);
            if (isset($city_entity)) {
                $item['city'] = $city_entity->toArray();
                $item['city_name'] = $city_entity->name;
            }
            /** @var ProvinceEntity $province_entity */
            $province_entity = $province_repository->fetch($provider_service_network_entity->province_id);
            if (isset($province_entity)) {
                $item['province_name'] = $province_entity->name;
            }
            $items[] = $item;
        }

        return $items;
    }
}

