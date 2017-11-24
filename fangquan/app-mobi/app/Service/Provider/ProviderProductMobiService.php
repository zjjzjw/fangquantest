<?php

namespace App\Mobi\Service\Provider;


use App\Service\FqUser\CheckTokenService;
use App\Src\Product\Domain\Model\ProductCategoryEntity;
use App\Src\Product\Infra\Repository\ProductCategoryRepository;
use App\Src\Provider\Domain\Model\ProviderNewsEntity;
use App\Src\Provider\Domain\Model\ProviderProductEntity;
use App\Src\Provider\Domain\Model\ProviderProductSpecification;
use App\Src\Provider\Domain\Model\ProviderProjectEntity;
use App\Src\Provider\Infra\Repository\ProviderNewsRepository;
use App\Src\Provider\Infra\Repository\ProviderProductFavoriteRepository;
use App\Src\Provider\Infra\Repository\ProviderProductRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;

class ProviderProductMobiService
{
    public function getProviderProjectBySpec(ProviderProductSpecification $spec)
    {
        $items = [];
        $provider_product_repository = new ProviderProductRepository();
        $provider_product_entities = $provider_product_repository->getProviderProductBySpec($spec);
        $resource_repository = new ResourceRepository();
        /** @var ProviderProductEntity $provider_product_entity */
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


    public function getProviderProductById($id)
    {
        $data = [];
        $provider_product_repository = new ProviderProductRepository();
        $resource_repository = new ResourceRepository();
        /** @var ProviderProductEntity $provider_product_entity */
        $provider_product_entity = $provider_product_repository->fetch($id);
        $data['id'] = $provider_product_entity->id;
        $data['name'] = $provider_product_entity->name;
        $data['price_low'] = $provider_product_entity->price_low;
        $data['price_high'] = $provider_product_entity->price_high;
        //供应商产品图片
        $image_ids = $provider_product_entity->provider_product_images;
        $resource_entities = $resource_repository->getResourceUrlByIds($image_ids);
        $data['product_image'] = [];
        /** @var ResourceEntity $resource_entity */
        foreach ($resource_entities as $resource_entity) {
            $data['product_image'][] = ['image' => $resource_entity->url];
        }
        //供应商产品参数
        $data['attrib'] = $provider_product_entity->attrib ? json_decode($provider_product_entity->attrib, true) : [];
        $data['has_collected'] = false;
        if (CheckTokenService::isLogin()) {
            $user_id = CheckTokenService::getUserId();
            $provider_product_favorite_repository = new ProviderProductFavoriteRepository();
            $provider_product_favorite_entities = $provider_product_favorite_repository
                ->getProviderProductFavoriteByUserIdAndProductId(
                    $user_id, $id
                );
            if (!$provider_product_favorite_entities->isEmpty()) {
                $data['has_collected'] = true;
            }
        }
        return $data;
    }

    /**
     * 得到二级分类下面的产品
     * @param int $second_category_id
     * @return array
     */
    public function getProductBySecondCategoryId($second_category_id)
    {
        $items = [];
        $provider_product_repository = new ProviderProductRepository();
        $provider_product_specification = new ProviderProductSpecification();
        $provider_product_specification->second_product_category_id = $second_category_id;
        $provider_product_entities = $provider_product_repository->getProviderProductBySpec(
            $provider_product_specification
        );
        foreach ($provider_product_entities as $provider_product_entity) {
            $item = [];
            $item['id'] = $provider_product_entity->id;
            $item['name'] = $provider_product_entity->name;
            $items[] = $item;
        }
        return $items;
    }


    public function getProviderProductsByIds($ids)
    {
        $ids = explode(',', $ids);
        $items = [];
        $provider_product_repository = new ProviderProductRepository();
        $resource_repository = new ResourceRepository();
        /** @var ProviderProductEntity $provider_product_entities */
        $provider_product_entities = $provider_product_repository->getProviderProductsByIds($ids);
        if (isset($provider_product_entities)) {
            foreach ($provider_product_entities as $provider_product_entity) {
                $item['name'] = $provider_product_entity->name;
                $item['price_low'] = $provider_product_entity->price_low;
                $item['price_high'] = $provider_product_entity->price_high;
                $item['product_category_id'] = $provider_product_entity->product_category_id;
                //供应商产品图片
                $image_ids = $provider_product_entity->provider_product_images;
                $resource_entities = $resource_repository->getResourceUrlByIds($image_ids);
                /** @var ResourceEntity $resource_entity */
                foreach ($resource_entities as $resource_entity) {
                    $item['logo'] = $resource_entity->url;
                }
                //供应商产品参数
                $item['attrib'] = $provider_product_entity->attrib ? json_decode($provider_product_entity->attrib, true) : [];
                $items[] = $item;
            }
        }
        return $items;
    }
}