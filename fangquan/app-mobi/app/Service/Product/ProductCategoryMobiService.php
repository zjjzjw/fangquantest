<?php

namespace App\Mobi\Service\Product;


use App\Service\Product\ProductCategoryService;
use App\Src\Product\Domain\Model\ProductCategoryEntity;
use App\Src\Product\Domain\Model\ProductCategoryType;
use App\Src\Product\Infra\Repository\ProductCategoryRepository;

class ProductCategoryMobiService
{

    /**
     * @param $parent_id
     * @param $status
     * @return array
     */
    public function getProductCategoryByParentId($parent_id, $status)
    {
        $items = [];
        $product_category_service = new ProductCategoryService();
        $product_categories = $product_category_service->getProductCategoryByParentId($parent_id, $status);
        foreach ($product_categories as $product_category) {
            $item['id'] = $product_category['id'];
            $item['name'] = $product_category['name'];
            $items[] = $item;
        }
        return $items;
    }

    /**
     * 得到一级二级分类
     * @return array
     */
    public function getProductCategoryList()
    {
        $items = [];
        $product_category_repository = new ProductCategoryRepository();
        $product_category_entities = $product_category_repository->getProductCategoryByLevelAndStatus([1, 2]);
        $product_categories = [];
        /** @var ProductCategoryEntity $product_category_entity */
        foreach ($product_category_entities as $product_category_entity) {
            $product_categories[] = $product_category_entity->toArray();
        }
        $first_categories = collect($product_categories)->where('level', 1)->toArray();
        foreach ($first_categories as $first_category) {
            $item = [];
            $item['id'] = $first_category['id'];
            $item['name'] = $first_category['name'];
            $item['categorys'] = [];
            $second_categories = collect($product_categories)->where('parent_id', $first_category['id'])->toArray();
            foreach ($second_categories as $second_category) {
                $second_item = [];
                $second_item['id'] = $second_category['id'];
                $second_item['name'] = $second_category['name'];
                $item['categorys'][] = $second_item;
            }
            $items[] = $item;
        }
        return $items;
    }

    /**
     * 获取主营分类
     * @param bool $icon
     * @return array
     */
    public function getCategoryList($icon = false)
    {
        $items = [];
        $category_repository = new ProductCategoryRepository();
        $icons = ProductCategoryType::acceptableAppIconEnums();
        $category_entity = $category_repository->getCategoryList();
        if ($icon) {
            foreach ($category_entity as $value) {
                $item['id'] = $value->id;
                $item['icon'] = $icons[$value->id] ?? '';
                $item['name'] = $value->name;
                $items[] = $item;
            }
        } else {
            foreach ($category_entity as $value) {
                $item['id'] = $value->id;
                $item['name'] = $value->name;
                $items[] = $item;
            }
        }
        return $items;
    }


}

