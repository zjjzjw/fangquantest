<?php

namespace App\Mobi\Service\Provider;


use App\Service\Provider\ProviderService;
use App\Src\Provider\Domain\Model\ProviderAdType;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderFavoriteEntity;
use App\Src\Provider\Domain\Model\ProviderFriendEntity;
use App\Src\Provider\Domain\Model\ProviderImageType;
use App\Src\Provider\Domain\Model\ProviderNewsEntity;
use App\Src\Provider\Domain\Model\ProviderPictureEntity;
use App\Src\Provider\Infra\Repository\ProviderFavoriteRepository;
use App\Src\Provider\Infra\Repository\ProviderFriendRepository;
use App\Src\Provider\Infra\Repository\ProviderNewsRepository;
use App\Src\Provider\Infra\Repository\ProviderPictureRepository;
use App\Src\Provider\Infra\Repository\ProviderRankCategoryRepository;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Src\Surport\Domain\Model\CityEntity;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\CityRepository;
use App\Src\Surport\Infra\Repository\ResourceRepository;

class ProviderFavoriteMobiService
{
    public function getProviderByUserId($use_id)
    {
        $items = [];
        $provider_favorite_repository = new ProviderFavoriteRepository();
        $provider_favorite_entities = $provider_favorite_repository->getProviderFavoriteByUserId($use_id);
        if ($provider_favorite_entities->isEmpty()) {
            return $items;
        }
        $provider_ids = [];
        /** @var ProviderFavoriteEntity $provider_favorite_entity */
        foreach ($provider_favorite_entities as $provider_favorite_entity) {
            $provider_ids[] = $provider_favorite_entity->provider_id;
        }
        $provider_repository = new ProviderRepository();
        $provider_entities = $provider_repository->getProviderByIds($provider_ids);
        $provider_service = new ProviderService();
        foreach ($provider_entities as $provider_entity) {
            $item = [];
            //获取图片信息
            $provider_picture_repository = new ProviderPictureRepository();
            $resource_repository = new ResourceRepository();
            $provider_picture_entities = $provider_picture_repository->getImageByProviderId($provider_entity->id);
            $image_ids = [];
            /** @var ProviderPictureEntity $provider_picture_entity */
            foreach ($provider_picture_entities as $provider_picture_entity) {
                $image_ids[] = $provider_picture_entity->image_id;
            }
            $resource_entities = $resource_repository->getResourceUrlByIds($image_ids);
            /** @var ResourceEntity $resource_entity */
            $images = [];
            $logo_images = [];
            $structure_images = [];
            $sub_structure_images = [];
            $factory_images = [];
            $device_images = [];

            foreach ($provider_picture_entities as $provider_picture_entity) {
                $image = $provider_picture_entity->toArray();
                foreach ($resource_entities as $resource_entity) {
                    if ($provider_picture_entity->image_id == $resource_entity->id) {
                        $image['url'] = $resource_entity->url;
                    }
                }
                $images[] = $image;
            }

            $logo_images = collect($images)->where('type', ProviderImageType::LOGO)->toArray();
            $license_images = collect($images)->where('type', ProviderImageType::LICENSE)->toArray();
            $structure_images = collect($images)->where('type', ProviderImageType::STRUCTURE)->toArray();
            $sub_structure_images = collect($images)->where('type', ProviderImageType::SUB_STRUCTURE)->toArray();
            $factory_images = collect($images)->where('type', ProviderImageType::FACTORY)->toArray();
            $device_images = collect($images)->where('type', ProviderImageType::DEVICE)->toArray();
            $item['id'] = $provider_entity->id;
            if ($provider_entity->is_ad == ProviderAdType::YES) {
                $item['is_ad'] = true;
                $item['is_picture_ad'] = false;
            } else {
                $item['is_ad'] = false;
            }
            $item['brand_name'] = $provider_entity->brand_name;
            $item['company_name'] = $provider_entity->company_name;
            if (!empty(($logo_images))) {
                $item['logo'] = current($logo_images)['url'];
            } else {
                $item['logo'] = '';
            }
            $main_categories = $provider_service->getProviderMainCategory($provider_entity->id);
            $item['main_categories'] = $main_categories;
            $city_repository = new CityRepository();
            $city_id = $provider_entity->city_id;
            /** @var CityEntity $city_entity */
            if (isset($city_id)) {
                $city_entity = $city_repository->fetch($provider_entity->city_id);
            }
            $item['city'] = $city_entity ? $city_entity->name : '';
            $items[] = $item;
        }
        return $items;
    }


}