<?php

namespace App\Mobi\Service\Provider;


use app\Src\Provider\Domain\Model\ProviderServiceNetworkEntity;
use App\Src\Provider\Domain\Model\ProviderServiceNetworkSpecification;
use App\Src\Provider\Infra\Repository\ProviderServiceNetworkRepository;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Infra\Repository\ProvinceRepository;

class ProviderServiceNetworkMobiService
{
    public function getProviderServiceNetworkByProviderIdAndStatus($provider_id, $status)
    {
        $items = [];
        $provider_service_network_repository = new ProviderServiceNetworkRepository();
        $provider_service_network_entities = $provider_service_network_repository->getProviderServiceNetworkByProviderIdAndStatus(
            $provider_id, $status
        );
        $province_repository = new ProvinceRepository();
        /** @var ProviderServiceNetworkEntity $provider_service_network_entity */
        foreach ($provider_service_network_entities as $provider_service_network_entity) {
            $item = [];
            $item['provider_id'] = $provider_service_network_entity->provider_id;
            $item['province_id'] = $provider_service_network_entity->province_id;
            /** @var ProvinceEntity $province_entity */
            $province_entity = $province_repository->fetch($provider_service_network_entity->province_id);
            if (isset($province_entity)) {
                $item['name'] = $province_entity->name;
            }
            $items[$item['province_id']] = $item;
        }
        $items = array_values($items);
        return $items;
    }


    public function getProviderServiceNetworkBySpec(ProviderServiceNetworkSpecification $spec)
    {
        $items = [];
        $provider_service_network_repository = new ProviderServiceNetworkRepository();
        $provider_service_network_entities = $provider_service_network_repository->getProviderServiceNetworkBySpec(
            $spec
        );
        /** @var ProviderServiceNetworkEntity $provider_service_network_entity */
        foreach ($provider_service_network_entities as $provider_service_network_entity) {
            $item = [];
            $item['id'] = $provider_service_network_entity->id;
            $item['name'] = $provider_service_network_entity->name;
            $item['address'] = $provider_service_network_entity->address;
            $item['contact'] = $provider_service_network_entity->contact;
            $item['telphone'] = $provider_service_network_entity->telphone;
            $items[] = $item;
        }
        return $items;
    }


    public function getProviderServiceNetworkCount($provider_id, $status)
    {
        $items = [];
        $provider_service_network_repository = new ProviderServiceNetworkRepository();
        $provider_service_network_entities = $provider_service_network_repository->getProviderServiceNetworkByProviderIdAndStatus(
            $provider_id, $status
        );
        $worker_count = [];
        foreach ($provider_service_network_entities as $provider_service_network_entity) {
            $item = $provider_service_network_entity->toArray();
            $worker_count[] = $item['worker_count'];
            $items[] = $item;
        }

        $provider_service_network = [
            'total_worker_count'    => array_sum($worker_count),
            'total_service_company' => count($items),
        ];
        return $provider_service_network;
    }
}