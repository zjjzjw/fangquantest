<?php

namespace App\Hulk\Service\Product;

use App\Src\Category\Domain\Model\AttributeEntity;
use App\Src\Category\Domain\Model\CategoryEntity;
use App\Src\Category\Infra\Repository\AttributeRepository;
use App\Src\Category\Infra\Repository\CategoryRepository;
use App\Src\Product\Domain\Model\ProductEntity;
use App\Src\Product\Domain\Model\ProductSpecification;
use App\Src\Product\Infra\Repository\ProductRepository;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Src\Product\Domain\Model\ProductHotType;

class ProductHulkService
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
        $product_hot_types = ProductHotType::acceptableEnums();
        $provider_repository = new ProviderRepository();
        $category_repository = new CategoryRepository();
        $items = [];
        /**
         * @var int                  $key
         * @var ProductEntity        $product_entity
         * @var LengthAwarePaginator $paginate
         */


        foreach ($paginate as $key => $product_entity) {
            $item['id'] = $product_entity->id;
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($product_entity->logo);
            $item['logo_url'] = $resource_entity->url ?? '';
            if (!empty($item['logo_url'])) {
                $item['logo_url'] .= '?imageView2/1/w/120/h/90';
            }
            $hots = $product_entity->product_hots ?? [];
            $product_hots = [];
            foreach ($hots as $key => $product_hot) {
                $product_hot = $product_hot_types[$product_hot];
                $product_hots[] = $product_hot;
            }
            $item['product_hots'] = $product_hots;
            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($product_entity->brand_id);
            $item['brand_name'] = $provider_entity->brand_name ?? '';
            /** @var CategoryEntity $category_entity */
            $category_entity = $category_repository->fetch($product_entity->product_category_id);
            $item['product_category_name'] = $category_entity->name;
            $item['product_category_id'] = $product_entity->product_category_id ?? 0;
            $item['price'] = $product_entity->price ?? '';
            $item['retail_price'] = rtrim(rtrim(number_format($product_entity->retail_price ?? 0, 2), 0), '.');
            $item['price_unit'] = $product_entity->price_unit ?? '';
            $item['engineering_price'] = rtrim(rtrim(number_format($product_entity->engineering_price ?? 0, 2), 0), '.');
            $item['product_model'] = $product_entity->product_model ?? '';
            $items[] = $item;
        }
        $data['list'] = $items;
        $data['count'] = $paginate->total();
        return $data;
    }


    /**
     * @param $id
     * @return array
     */
    public function getProductInfo($id)
    {

        $item = [];
        $product_repository = new ProductRepository();
        $provider_repository = new ProviderRepository();
        $resource_repository = new ResourceRepository();
        $category_repository = new CategoryRepository();
        $attribute_repository = new AttributeRepository();


        /** @var ProductEntity $product_entity */
        $product_entity = $product_repository->fetch($id);


        if (isset($product_entity)) {
            $resource_entities = $resource_repository->getResourceUrlByIds($product_entity->product_pictures);
            /** @var ResourceEntity $resource_entity */
            $images = [];
            foreach ($resource_entities as $resource_entity) {
                $image['url'] = $resource_entity->url;
                $image['image_id'] = $resource_entity->id;
                $images[] = $image;
            }
            $item['id'] = $product_entity->id;
            $item['product_picture'] = $images;
            $item['brand_id'] = $product_entity->brand_id;
            $item['product_category_id'] = $product_entity->product_category_id;
            $item['product_model'] = $product_entity->product_model;
            $item['price'] = $product_entity->price;
            $item['comment_count'] = $product_entity->comment_count;
            $item['retail_price'] = rtrim(rtrim(number_format($product_entity->retail_price ?? 0, 2), 0), '.');
            $item['price_unit'] = $product_entity->price_unit ?? '';
            $item['engineering_price'] = rtrim(rtrim(number_format($product_entity->engineering_price ?? 0, 2), 0), '.');

            $product_attribute_values = $product_entity->product_attribute_values;
            $product_attribute_values_format = [];
            foreach ($product_attribute_values as $product_attribute_value) {
                $product_attribute_values_format[$product_attribute_value['attribute_id']] = $product_attribute_value['value_id'];
            }
            $product_hot_types = ProductHotType::acceptableEnums();
            $hots = $product_entity->product_hots ?? [];
            $product_hots = [];
            foreach ($hots as $key => $product_hot) {
                $product_hot = $product_hot_types[$product_hot];
                $product_hots[] = $product_hot;
            }
            $item['product_hots'] = $product_hots;
            $product_params = $product_entity->product_params;
            $product_params_format = [];
            foreach ($product_params as $product_param) {
                $product_params_format[$product_param['category_param_id']] = $product_param['value'];
            }
            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($product_entity->brand_id);
            $item['brand_name'] = $provider_entity->brand_name ?? '';
            $item['telphone'] = $provider_entity->telphone ?? '';

            /** @var CategoryEntity $category_entity */
            $category_entity = $category_repository->fetch($product_entity->product_category_id);
            if (isset($category_entity)) {
                //参数
                $item['product_category_name'] = $category_entity->name;
                foreach ($category_entity->category_params as $key => $value) {
                    if (isset($product_params_format[$key])) {
                        $item['product_params'][$value] = $product_params_format[$key];
                    }
                }
                foreach ($category_entity->category_attributes as $key => $value) {
                    /** @var AttributeEntity $attribute_entity */
                    $attribute_entity = $attribute_repository->fetch($key);
                    if (array_key_exists($product_attribute_values_format[$attribute_entity->id] ?? 0, $attribute_entity->attribute_values)) {
                        $item['product_attribute_values'][$attribute_entity->name] = $attribute_entity->attribute_values[$product_attribute_values_format[$attribute_entity->id]];
                    }
                }
            }
        }
        return $item;
    }

    public function getBrandCategorys($brand_id)
    {
        $item = [];
        $product_repository = new ProductRepository();
        $category_repository = new CategoryRepository();
        $product_entities = $product_repository->getProductListByBrandId($brand_id);
        /** @var ProductEntity $product_entity */
        foreach ($product_entities as $product_entity) {
            /** @var CategoryEntity $category_entity */
            $category_entity = $category_repository->fetch($product_entity->product_category_id);
            $item[$product_entity->product_category_id] = $category_entity->name;
        }
        return $item;
    }
}

