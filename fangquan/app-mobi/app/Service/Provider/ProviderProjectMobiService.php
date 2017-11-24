<?php

namespace App\Mobi\Service\Provider;


use App\Src\Provider\Domain\Model\ProviderNewsEntity;
use App\Src\Provider\Domain\Model\ProviderProjectEntity;
use App\Src\Provider\Infra\Repository\ProviderNewsRepository;
use App\Src\Provider\Infra\Repository\ProviderProjectRepository;
use App\Src\Surport\Domain\Model\CityEntity;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\CityRepository;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use App\Src\Surport\Infra\Repository\ResourceRepository;

class ProviderProjectMobiService
{

    /**
     * 历史项目列表
     * @param int       $provider_id
     * @param int|array $status
     * @return array
     */
    public function getProviderProjectsByIdAndStatus($provider_id, $status)
    {
        $items = [];
        $provider_project_repository = new ProviderProjectRepository();
        $city_repository = new CityRepository();
        $province_repository = new ProvinceRepository();
        $resource_repository = new ResourceRepository();
        $provider_project_entities = $provider_project_repository->getProviderProjectByProviderIdAndStatus(
            $provider_id, $status
        );


        /** @var ProviderProjectEntity $provider_project_entity */
        foreach ($provider_project_entities as $provider_project_entity) {
            $item = [];
            $item['id'] = $provider_project_entity->id;
            $image_ids = $provider_project_entity->provider_project_picture_ids;
            $resource_entities = $resource_repository->getResourceUrlByIds($image_ids);
            /** @var ResourceEntity $resource_entity */
            $resource_entity = current($resource_entities);
            if (!empty($resource_entity)) {
                $item['image'] = $resource_entity->url;
            } else {
                $item['image'] = '';
            }
            $item['developer_name'] = $provider_project_entity->developer_name;
            /** @var CityEntity $city_entity */
            $city_entity = $city_repository->fetch($provider_project_entity->city_id);
            if ($city_entity) {
                $item['address'] = $city_entity->name;
            } else {
                $item['address'] = '';
            }
            $item['time'] = $provider_project_entity->created_at->toDateTimeString();
            $item['project_product'] = [];
            $items[] = $item;
        }
        return $items;
    }

    /**
     * 历史项目详情
     * @param  int $id
     * @return array
     */
    public function getProviderProjectById($id)
    {
        $data = [];
        $provider_project_repository = new ProviderProjectRepository();
        $resource_repository = new ResourceRepository();
        $city_repository = new CityRepository();
        /** @var ProviderProjectEntity $provider_project_entity */
        $provider_project_entity = $provider_project_repository->fetch($id);
        if (isset($provider_project_entity)) {
            $data['id'] = $provider_project_entity->id;
            $image_ids = $provider_project_entity->provider_project_picture_ids;
            $resource_entities = $resource_repository->getResourceUrlByIds($image_ids);
            $data['images'] = [];
            /** @var ResourceEntity $resource_entity */
            foreach ($resource_entities as $resource_entity) {
                $data['images'][] = ['image' => $resource_entity->url];
            }
            $data['developer_name'] = $provider_project_entity->developer_name;
            /** @var CityEntity $city_entity */
            $city_entity = $city_repository->fetch($provider_project_entity->city_id);
            if ($city_entity) {
                $data['address'] = $city_entity->name;
            } else {
                $data['address'] = '';
            }
            $data['time'] = $provider_project_entity->created_at->toDateTimeString();
            $data['project_product'] = [];
        }
        return $data;
    }

}