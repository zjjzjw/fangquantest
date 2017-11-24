<?php

namespace App\Web\Service\Provider;

use App\Src\Provider\Infra\Repository\ProviderProductRepository;
use App\Src\Product\Infra\Repository\ProductCategoryRepository;
use App\Src\Provider\Domain\Model\ProviderProductSpecification;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use App\Src\Provider\Domain\Model\ProviderProductEntity;
use App\Src\Provider\Domain\Model\ProviderProductStatus;
use App\Src\Product\Domain\Model\ProductCategoryEntity;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Surport\Domain\Model\ResourceEntity;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Service\Product\ProductCategoryService;

class ProviderProductWebService
{
    /**
     * 产品展示列表abstract
     * @param ProviderProductSpecification $spec
     * @param                              $per_page
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
            $item['status_name'] = $provider_product_status[$item['status']];
            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($item['provider_id']);
            if (isset($provider_entity)) {
                $item['brand_name'] = $provider_entity->brand_name;
            }
            $images = [];
            $image = [];
            $resource_entities = $resource_repository->getResourceUrlByIds(
                $provider_product_entity->provider_product_images);
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

    /**
     * 产品详细内容info
     * @param $id
     * @return array
     */
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
        }
        return $data;
    }

    public function getProductCategoryByUserId($user_id, $status)
    {
        $categories = [];
        $product_category_repository = new ProductCategoryRepository();
        $provider_product_repository = new ProviderProductRepository();
        $product_category_service = new ProductCategoryService();
        $provider_product_entities = $provider_product_repository->getProductCategoryByUserId($user_id,$status);
        foreach ($provider_product_entities as $provider_product_entity){
            $product_category_entity = $product_category_repository->fetch($provider_product_entity->product_category_id);
            if (isset($product_category_entity)) {
                $item['product_category'] = $product_category_entity->toArray();
                $categories[] = $item['product_category']['parent_id'];
            }
        }

        $category_count = array_count_values($categories);
        $product_categories = $product_category_service->getProductCategoryByCategoryIds($categories);
        $search_categories[0] = [
            'name' => '全部',
            'count' => array_sum($category_count),
        ];
        foreach ($product_categories as $provider_main_category) {
            $search_categories[$provider_main_category['id']] = [
                'name' => $provider_main_category['name'],
                'count' => $category_count[$provider_main_category['id']]
            ];
        }
        return $search_categories;
    }
}