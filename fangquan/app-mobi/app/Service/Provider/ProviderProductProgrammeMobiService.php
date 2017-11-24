<?php

namespace App\Mobi\Service\Provider;


use App\Service\FqUser\CheckTokenService;
use App\Src\Provider\Domain\Model\ProviderProductProgrammeEntity;
use App\Src\Provider\Infra\Repository\ProductProgrammeFavoriteRepository;
use App\Src\Provider\Infra\Repository\ProviderProductProgrammeRepository;
use App\Src\Provider\Infra\Repository\ProviderProductRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;

class ProviderProductProgrammeMobiService
{
    public function getProviderProductProgrammeByProviderId($provider_id)
    {
        $items = [];
        $provider_product_programme_repository = new ProviderProductProgrammeRepository();
        $provider_product_repository = new ProviderProductRepository();
        $provider_product_programme_entities = $provider_product_programme_repository->getProviderProductProgrammeByProviderId($provider_id);
        $resource_repository = new ResourceRepository();
        /** @var ProviderProductProgrammeEntity $provider_product_programme_entity */
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


    public function getProviderProductProgrammeById($id)
    {
        $data = [];
        $provider_product_programme_repository = new ProviderProductProgrammeRepository();
        $provider_product_repository = new ProviderProductRepository();
        $resource_repository = new ResourceRepository();
        /** @var ProviderProductProgrammeEntity $provider_product_programme_entity */
        $provider_product_programme_entity = $provider_product_programme_repository->fetch($id);
        if (isset($provider_product_programme_entity)) {
            $data['id'] = $provider_product_programme_entity->id;
            $data['title'] = $provider_product_programme_entity->title;
            if (!empty($provider_product_programme_entity->product)) {
                $provider_product_entity = $provider_product_repository->getProviderProductsByIds($provider_product_programme_entity->product);
                $price_low = $provider_product_entity->sum('price_low');
                $price_high = $provider_product_entity->sum('price_high');
                $data['price_low'] = $price_low;
                $data['price_high'] = $price_high;
                $product_arr = [];
                /** @var ResourceEntity $resource_entity */
                foreach ($provider_product_entity as $provider_product) {
                    $product['id'] = $provider_product->id;
                    $product['title'] = $provider_product->name;
                    if (!empty($provider_product->provider_product_images)) {
                        $product_logo_id = current($provider_product->provider_product_images);
                        $resource_entity = $resource_repository->fetch($product_logo_id);
                        $product_logo_id = $resource_entity->url;
                        $product['logo'] = $product_logo_id;
                    }
                    $product['price_low'] = $provider_product->price_low;
                    $product['price_high'] = $provider_product->price_high;
                    $product_arr[] = $product;
                }
                $data['provider_product'] = $product_arr;
            }
            $data['has_collected'] = false;

            if (CheckTokenService::isLogin()) {
                $user_id = CheckTokenService::getUserId();
                $provider_product_favorite_repository = new ProductProgrammeFavoriteRepository();
                $provider_product_favorite_entities = $provider_product_favorite_repository
                    ->getProductProgrammeFavoriteByProgrammeIdAndUserId(
                        $user_id, $id
                    );
                if (!$provider_product_favorite_entities->isEmpty()) {
                    $data['has_collected'] = true;
                }
            }

            $data['desc'] = $provider_product_programme_entity->desc;
            $pictures = $provider_product_programme_entity->provider_product_programme_pictures;
            if (!empty($pictures)) {
                $resource_entity = $resource_repository->fetch(current($pictures));
                $data['logo'] = $resource_entity->url;
            }
        }
        return $data;
    }
}