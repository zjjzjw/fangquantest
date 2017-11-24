<?php

namespace App\Mobi\Service\Provider;


use App\Src\Provider\Domain\Model\ProviderProductFavoriteEntity;
use App\Src\Provider\Infra\Repository\ProviderProductFavoriteRepository;
use App\Src\Provider\Infra\Repository\ProviderProductRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;

class ProviderProductFavoriteMobiService
{
    public function getProviderProductByUserId($use_id)
    {
        $items = [];
        $provider_product_favorite_repository = new ProviderProductFavoriteRepository();
        $provider_product_favorite_entities = $provider_product_favorite_repository
            ->getProviderProductFavoriteByUserId($use_id);
        if ($provider_product_favorite_entities->isEmpty()) {
            return $items;
        }
        $provider_product_ids = [];
        /** @var ProviderProductFavoriteEntity $provider_product_favorite_entity */
        foreach ($provider_product_favorite_entities as $provider_product_favorite_entity) {
            $provider_product_ids[] = $provider_product_favorite_entity->provider_product_id;
        }
        $provider_product_repository = new ProviderProductRepository();
        $provider_product_entities = $provider_product_repository->getProviderProductsByIds(
            $provider_product_ids
        );


        $resource_repository = new ResourceRepository();
        foreach ($provider_product_entities as $provider_product_entity) {
            $item = [];
            $item['id'] = $provider_product_entity->id;
            $item['name'] = $provider_product_entity->name;
            $item['price_low'] = $provider_product_entity->price_low;
            $item['price_high'] = $provider_product_entity->price_high;
            $image_ids = $provider_product_entity->provider_product_images;
            $resource_entities = $resource_repository->getResourceUrlByIds($image_ids);
            /** @var ResourceEntity $resource_entity */
            $resource_entity = current($resource_entities);
            if (!empty($resource_entity)) {
                $item['logo'] = $resource_entity->url;
            } else {
                $item['logo'] = '';
            }
            $items[] = $item;
        }
        return $items;
    }

}