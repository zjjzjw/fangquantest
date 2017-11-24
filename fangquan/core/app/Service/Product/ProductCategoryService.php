<?php

namespace App\Service\Product;


use App\Src\Product\Domain\Model\ProductCategoryEntity;
use App\Src\Product\Domain\Model\ProductCategorySpecification;
use App\Src\Product\Domain\Model\ProductCategoryStatus;
use App\Src\Product\Domain\Model\ProductCategoryType;
use App\Src\Product\Infra\Repository\ProductCategoryRepository;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderSpecification;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductCategoryService
{
    public function getAllProviderCategoryTreeList()
    {
        $items = [];
        $product_category_repository = new ProductCategoryRepository();

        $product_category_entities = $product_category_repository->allProductCategory();

        /** @var ProductCategoryEntity $product_category_entity */
        foreach ($product_category_entities as $product_category_entity) {
            $item = $product_category_entity->toArray();
            $product_category_status = ProductCategoryStatus::acceptableEnums();
            $item['status_name'] = $product_category_status[$item['status']] ?? '';
            $items[] = $item;
        }
        $data = $product_category_repository->treeDataList($items);

        return $data;
    }


    /**
     * 获取供应商主营分类
     * @param $status
     * @return array
     */
    public function getProviderMainCategoryList($status)
    {
        $product_category_repository = new ProductCategoryRepository();
        $paginate = $product_category_repository->allProductCategory($status);
        $items = collect($paginate);
        $rows = $items->where('parent_id', 0);
        foreach ($rows as $key => $row) {
            $row = (array)$row;
            $second_category = $items->where('parent_id', $row['id'])->toArray();
            $second_category_arr = [];
            foreach ($second_category as $k => $v) {
                $second_category_arr[] = (array)$v;
            }
            $row['main_category'] = $second_category_arr;
            $rows[$key] = $row;
        }
        return $rows->toArray();
    }

    /**
     * @param int $status
     * @return array
     */
    public function getThirdProductCategoryList($second_ids, $status)
    {
        $items = [];
        $product_category_repository = new ProductCategoryRepository();
        $product_category_entities = $product_category_repository->getThirdProductCategory($second_ids, $status);

        foreach ($product_category_entities as $product_category_entity) {
            $item = $product_category_entity->toArray();
            $items[] = $item;
        }
        return $items;
    }

    /**
     * @param int $status
     * @return array
     */
    public function getProductCategoryListByIdsAndLevel($second_ids, $status)
    {
        $items = [];
        $product_category_repository = new ProductCategoryRepository();
        $product_category_entities = $product_category_repository->getProductCategoryByIdsAndLevel($second_ids, $status);

        foreach ($product_category_entities as $product_category_entity) {
            $item = $product_category_entity->toArray();
            $items[] = $item;
        }
        return $items;
    }

    /**
     * @param $product_category_ids
     * @return array|string
     */
    public function getProductCategoryByIds($product_category_ids)
    {
        $product_category_repository = new ProductCategoryRepository();
        $product_category_models = $product_category_repository->getProductCategoryByIds($product_category_ids);
        $product_category_names = [];
        foreach ($product_category_models as $product_category_model) {
            $product_category_names[] = $product_category_model->name;
        }
        $product_category_names = implode(',', $product_category_names);
        return $product_category_names;
    }

    public function getProductCategoryByCategoryIds($product_category_ids)
    {
        $items = [];
        $product_category_repository = new ProductCategoryRepository();
        $product_category_entities = $product_category_repository->getProductCategoryByIds($product_category_ids);
        foreach ($product_category_entities as $product_category_entity) {
            $item = $product_category_entity->toArray();
            $items[] = $item;
        }

        return $items;
    }

    /**
     * 根据level获取产品分类
     * @param $level
     * @param $status
     * @return array
     */
    public function getProductCategoryByLevel($level, $status)
    {
        $items = [];
        $product_category_repository = new ProductCategoryRepository();
        $product_category_entities = $product_category_repository->getProductCategoryByLevel($level, $status);
        /** @var ProductCategoryEntity $product_category_entity */
        foreach ($product_category_entities as $product_category_entity) {
            $item = $product_category_entity->toArray();
            $items[] = $item;
        }
        return $items;
    }


    /**
     * @param int $parent_id
     * @param int $status
     * @return array
     */
    public function getProductCategoryByParentId($parent_id, $status)
    {
        $items = [];
        $product_category_repository = new ProductCategoryRepository();
        $product_category_entities = $product_category_repository->getProductCategoryByParentId($parent_id, $status);
        /** @var ProductCategoryEntity $product_category_entity */
        foreach ($product_category_entities as $product_category_entity) {
            $item = $product_category_entity->toArray();
            $product_category_icons = ProductCategoryType::acceptableIconEnums();
            $item['icon'] = $product_category_icons[$product_category_entity->id] ?? '';
            $items[] = $item;
        }
        return $items;
    }

    /**
     * @param $id
     * @return array
     */
    public function getProductCategoryInfo($id)
    {
        $data = [];
        $product_category_repository = new ProductCategoryRepository();
        $resource_repository = new ResourceRepository();
        /** @var ProductCategoryEntity $product_category_entity */
        $product_category_entity = $product_category_repository->fetch($id);
        if (isset($product_category_entity)) {
            $data = $product_category_entity->toArray();
            $data['attribfield_light'] = json_decode($product_category_entity->attribfield, true);
            //得到缩略图
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($product_category_entity->logo);
            if (isset($resource_entity)) {
                $data['thumbnail_url'] = $resource_entity->url;
                $thumbnail_images = [];
                $thumbnail_image = [];
                $thumbnail_image['image_id'] = $product_category_entity->logo;
                $thumbnail_image['url'] = $resource_entity->url;
                $thumbnail_images[] = $thumbnail_image;
                $data['thumbnail_images'] = $thumbnail_images;
                $data['logo_url'] = $resource_entity->url;
            }
        }
        return $data;
    }


}

