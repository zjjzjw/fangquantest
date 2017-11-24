<?php

namespace App\Mobi\Service\Provider;


use App\Src\Provider\Domain\Model\ProductProgrammeFavoriteEntity;
use App\Src\Provider\Infra\Repository\ProductProgrammeFavoriteRepository;
use App\Src\Provider\Infra\Repository\ProviderProductProgrammeRepository;
use App\Src\Provider\Infra\Repository\ProviderProductRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;

class ProviderProductProgrammeFavoriteMobiService
{
    public function getProductProgrammeByUserId($use_id)
    {
        $items = [];
        $product_programme_favorite_repository = new ProductProgrammeFavoriteRepository();
        $product_programme_favorite_entities = $product_programme_favorite_repository
            ->getProductProgrammeFavoriteByProgrammeIdAndUserId($use_id);

        $product_programme_ids = [];
        /** @var ProductProgrammeFavoriteEntity $product_programme_favorite_entity */
        foreach ($product_programme_favorite_entities as $product_programme_favorite_entity) {
            $product_programme_ids[] = $product_programme_favorite_entity->product_programme_id;
        }
        $provider_product_programme_repository = new ProviderProductProgrammeRepository();
        $provider_product_programme_entities = $provider_product_programme_repository->getProviderProductProgrammesByIds(
            $product_programme_ids
        );

        $resource_repository = new ResourceRepository();
        $provider_product_repository = new ProviderProductRepository();
        foreach ($provider_product_programme_entities as $provider_product_programme_entity) {
            $item = [];
            $item['id'] = $provider_product_programme_entity->id;
            $item['title'] = $provider_product_programme_entity->title;
            if (!empty($provider_product_programme_entity->product)) {
                $provider_product_entity = $provider_product_repository->getProviderProductsByIds($provider_product_programme_entity->product);
                $price_low = $provider_product_entity->sum('price_low');
                $price_high = $provider_product_entity->sum('price_high');
                $item['price_low'] = $price_low;
                $item['price_high'] = $price_high;
            }
            /** @var ResourceEntity $resource_entity */
            $pictures = $provider_product_programme_entity->provider_product_programme_pictures;
            if (!empty($pictures)) {
                $resource_entity = $resource_repository->fetch(current($pictures));
                $item['logo'] = $resource_entity->url;
            }
            $items[] = $item;
        }
        return $items;
    }

}