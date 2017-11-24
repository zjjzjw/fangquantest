<?php

namespace App\Service\Product;


use App\Service\Category\CategoryService;
use App\Src\Brand\Domain\Model\BrandEntity;
use App\Src\Brand\Infra\Repository\BrandRepository;
use App\Src\Category\Domain\Model\CategoryEntity;
use App\Src\Category\Infra\Repository\CategoryRepository;
use App\Src\Information\Domain\Model\InformationStatus;
use App\Src\Product\Domain\Model\ProductStatus;
use App\Src\Product\Infra\Repository\ProductRepository;
use App\Src\Product\Domain\Model\ProductEntity;
use App\Src\Product\Domain\Model\ProductSpecification;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Src\Surport\Infra\Repository\ResourceRepository;

class ProductService
{
    /**
     * @param ProductSpecification $spec
     * @param int                  $per_page
     * @return array
     */
    public function getProductList(ProductSpecification $spec, $per_page)
    {
        $data = [];
        $product_repository = new ProductRepository();
        $paginate = $product_repository->search($spec, $per_page);
        $resource_repository = new ResourceRepository();
        $provider_repository = new ProviderRepository();
        $category_repository = new CategoryRepository();

        $items = [];
        /**
         * @var int                  $key
         * @var ProductEntity        $product_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $product_entity) {
            $item = $product_entity->toArray();
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($item['logo']);
            if (isset($resource_entity)) {
                $item['logo_url'] = $resource_entity->url;
            }
            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($item['brand_id']);
            if (isset($provider_entity)) {
                $item['brand_name'] = $provider_entity->brand_name;
                $item['company_name'] = $provider_entity->company_name;
            }
            /** @var CategoryEntity $category_entity */
            $category_entity = $category_repository->fetch($item['product_category_id']);
            if (isset($category_entity)) {
                $item['product_category_name'] = $category_entity->name;
            }
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
     * @param $id
     * @return array
     */
    public function getProductInfo($id)
    {
        $data = [];
        $product_repository = new ProductRepository();
        $provider_repository = new ProviderRepository();
        $resource_repository = new ResourceRepository();
        $category_repository = new CategoryRepository();
        /** @var ProductEntity $product_entity */
        $product_entity = $product_repository->fetch($id);

        if (isset($product_entity)) {
            $data = $product_entity->toArray();
            //得到缩略图
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($product_entity->logo);
            if (isset($resource_entity)) {
                $data['thumbnail_url'] = $resource_entity->url;
                $thumbnail_images = [];
                $thumbnail_image = [];
                $thumbnail_image['image_id'] = $product_entity->logo;
                $thumbnail_image['url'] = $resource_entity->url;
                $thumbnail_images[] = $thumbnail_image;
                $data['logo'] = $thumbnail_images;
                $data['logo_url'] = $resource_entity->url;
            }

            $resource_entities = $resource_repository->getResourceUrlByIds($data['product_pictures']);
            /** @var ResourceEntity $resource_entity */
            $images = [];
            foreach ($resource_entities as $resource_entity) {
                $image['url'] = $resource_entity->url;
                $image['image_id'] = $resource_entity->id;
                $images[] = $image;
            }
            $data['product_picture'] = $images;
            $category_service = new CategoryService();
            $category_info = $category_service->getCategoryAndAttributeInfo($data['product_category_id']);
            $data['category_attributes'] = $category_info['category_attributes'];
            $data['category_params'] = $category_info['category_params'] ?? [];
            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($product_entity->brand_id);
            if (isset($provider_entity)) {
                $data['brand_name'] = $provider_entity->brand_name;
            }
            /** @var CategoryEntity $category_entity */
            $category_entity = $category_repository->fetch($data['product_category_id']);
            if (isset($category_entity)) {
                $data['product_category_name'] = $category_entity->name;
                $data['price_name'] = $category_entity->price;
            }
        }
        return $data;
    }

    public function getProductLists()
    {
        $data = [];
        $product_repository = new ProductRepository();
        $product_entities = $product_repository->all();
        foreach ($product_entities as $product_entity) {
            $item = $product_entity->toArray();
            $data[] = $item;
        }
        return $data;
    }
}

