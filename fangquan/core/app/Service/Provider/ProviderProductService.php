<?php

namespace App\Service\Provider;


use App\Src\Product\Domain\Model\ProductCategoryEntity;
use App\Src\Product\Infra\Repository\ProductCategoryRepository;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderProductEntity;
use App\Src\Provider\Domain\Model\ProviderProductSpecification;
use App\Src\Provider\Domain\Model\ProviderProductStatus;
use App\Src\Provider\Infra\Repository\ProviderProductFavoriteRepository;
use App\Src\Provider\Infra\Repository\ProviderProductRepository;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Service\Product\ProductCategoryService;

class ProviderProductService
{
    /**
     * @param ProviderProductSpecification $spec
     * @param int                          $per_page
     * @return array
     */
    public function getProviderProductList(ProviderProductSpecification $spec, $per_page)
    {
        $data = [];
        $product_category_repository = new ProductCategoryRepository();
        $provider_product_repository = new ProviderProductRepository();
        $provider_repository = new ProviderRepository();
        $resource_repository = new ResourceRepository();
        $provider_product_status = ProviderProductStatus::acceptableEnums();
        $paginate = $provider_product_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var int                   $key
         * @var ProviderProductEntity $provider_product_entity
         * @var LengthAwarePaginator  $paginate
         */
        foreach ($paginate as $key => $provider_product_entity) {
            $item = $provider_product_entity->toArray();
            $product_category_entity = $product_category_repository->fetch($provider_product_entity->product_category_id);

            if (isset($product_category_entity)) {
                $item['product_category'] = $product_category_entity->toArray();
            }

            $resource_entities = $resource_repository->getResourceUrlByIds($item['provider_product_images']);
            $item['product_image'] = [];
            /** @var ResourceEntity $resource_entity */
            foreach ($resource_entities as $resource_entity) {
                $item['product_image'][] = ['image' => $resource_entity->url];
            }
            $item['product_image_thumb'] = current($item['product_image'])['image'] ?? '/www/images/provider/default_logo.png';

            $item['status_name'] = $provider_product_status[$item['status']];
            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($item['provider_id']);
            if (isset($provider_entity)) {
                $item['brand_name'] = $provider_entity->brand_name;
            }
            $images = [];
            $image = [];

            /** @var ResourceEntity $resource_entity */
            foreach ($resource_entities as $resource_entity) {
                $image['image_id'] = $resource_entity->id;
                $image['url'] = $resource_entity->url;
                $images[] = $image;
            }
            $item['product_images'] = $images;
            $items[] = $item;
        }

        $data['paginate'] = $paginate;
        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();

        return $data;
    }


    public function getProviderProductInfo($id)
    {
        $data = [];
        $provider_product_repository = new ProviderProductRepository();
        $provider_repository = new ProviderRepository();
        $product_category_repository = new ProductCategoryRepository();
        /** @var ProviderProductEntity $provider_product_entity */
        $provider_product_entity = $provider_product_repository->fetch($id);

        if (isset($provider_product_entity)) {
            $data = $provider_product_entity->toArray();

            if (!empty($provider_product_entity->provider_product_images)) {
                $images = [];
                $image = [];
                $resource_repository = new ResourceRepository();
                $resource_entities = $resource_repository->getResourceUrlByIds(
                    $provider_product_entity->provider_product_images);
                /** @var ResourceEntity $resource_entity */
                foreach ($resource_entities as $resource_entity) {
                    $image['image_id'] = $resource_entity->id;
                    $image['url'] = $resource_entity->url;
                    $images[] = $image;
                }
                $data['product_images'] = $images;
                /** @var ProviderEntity $provider_entity */
                $provider_entity = $provider_repository->fetch($provider_product_entity->provider_id);
                if (isset($provider_entity)) {
                    $data['brand_name'] = $provider_entity->brand_name;
                    $data['company_name'] = $provider_entity->company_name;
                }
                /** @var ProductCategoryEntity $product_category_entity */
                $product_category_entity = $product_category_repository->fetch($provider_product_entity->product_category_id);
                if (isset($product_category_entity)) {
                    $data['product_category_name'] = $product_category_entity->name;
                }
            }
            $data['has_collected'] = false;
            if (request()->user()) {
                $user_id = request()->user()->id;
                $provider_product_favorite_repository = new ProviderProductFavoriteRepository();
                $provider_product_favorite_entities = $provider_product_favorite_repository->getProviderProductFavoriteByUserIdAndProductId(
                    $user_id, $id
                );
                if (!$provider_product_favorite_entities->isEmpty()) {
                    $data['has_collected'] = true;
                }
            }
        }

        return $data;
    }

    /**
     *
     * @param $json_attrib
     * @param $product_category_id
     * @param $product_categories
     * @return mixed
     */
    public function overlapAttribForCategoies($json_attrib, $product_category_id, $product_categories)
    {
        if (!empty($json_attrib)) {
            $old_attribs = json_decode($json_attrib, true);
            $old_items = [];
            foreach ($old_attribs as $old_attrib) {
                foreach ($old_attrib['nodes'] as $nodes) {
                    $item = [
                        'key'   => $nodes['key'],
                        'value' => $nodes['value'],
                    ];
                    $old_items[] = $item;
                }
            }
            foreach ($product_categories as &$product_category) {
                $product_category['attrib'] = json_decode($product_category['attribfield'], true);
                if ($product_category['id'] == $product_category_id) {
                    foreach ($product_category['attrib'] as &$new_attribs) {
                        foreach ($new_attribs['nodes'] as &$new_attrib) {
                            foreach ($old_items as $old_item) {
                                if ($new_attrib['key'] == $old_item['key']) {
                                    $new_attrib['value'] = $old_item['value'];
                                }
                            }
                        }
                    }
                    break;
                }
            }
        } else {
            foreach ($product_categories as &$product_category) {
                $product_category['attrib'] = json_decode($product_category['attribfield'], true);
            }
        }

        return $product_categories;
    }


    public function getProviderMainCategory($provider_id)
    {
        $provider_product_repository = new ProviderProductRepository();
        $category_category_ids = $provider_product_repository->getProviderMainCategoryIds($provider_id);

        return $category_category_ids;
    }

    /**
     * @param $provider_id
     * @param $status
     * @return array
     */
    public function getProviderProductListByProviderIdAndStatus($provider_id, $status)
    {
        $data = [];
        $provider_product_repository = new ProviderProductRepository();
        /** @var ProviderProductEntity $provider_product_entities */
        $provider_product_entities = $provider_product_repository->getProviderProductByProviderIdAndStatus($provider_id, $status);
        foreach ($provider_product_entities as $provider_product_entity) {
            $item = $provider_product_entity->toArray();
            $data[] = $item;
        }
        return $data;
    }


    public function getProductCategoryByUserId($user_id, $status)
    {
        $categories = [];
        $product_category_repository = new ProductCategoryRepository();
        $provider_product_repository = new ProviderProductRepository();
        $product_category_service = new ProductCategoryService();
        $provider_product_entities = $provider_product_repository->getProductCategoryByUserId($user_id, $status);
        foreach ($provider_product_entities as $provider_product_entity) {
            $product_category_entity = $product_category_repository->fetch($provider_product_entity->product_category_id);
            if (isset($product_category_entity)) {
                $item['product_category'] = $product_category_entity->toArray();
                $categories[] = $item['product_category']['parent_id'];
            }
        }

        $category_count = array_count_values($categories);
        $product_categories = $product_category_service->getProductCategoryByCategoryIds($categories);
        $search_categories[0] = [
            'name'  => '全部',
            'count' => array_sum($category_count),
        ];
        foreach ($product_categories as $provider_main_category) {
            $search_categories[$provider_main_category['id']] = [
                'name'  => $provider_main_category['name'],
                'count' => $category_count[$provider_main_category['id']],
            ];
        }
        return $search_categories;
    }
}
