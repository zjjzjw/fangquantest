<?php

namespace App\Hulk\Service\Category;


use App\Src\Category\Domain\Model\AttributeEntity;
use App\Src\Category\Domain\Model\CategoryEntity;
use App\Src\Category\Infra\Repository\AttributeRepository;
use App\Src\Category\Infra\Repository\CategoryRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;

class CategoryHulkService
{
    public function getLevelCategorys($level)
    {
        $items = [];
        $category_repository = new CategoryRepository();
        $resource_repository = new ResourceRepository();
        $category_entities = $category_repository->getLevelCategorys($level);
        /** @var CategoryEntity $category_entity */
        foreach ($category_entities as $category_entity) {
            $item = [];
            $item['id'] = $category_entity->id;
            $item['name'] = $category_entity->name;
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($category_entity->image_id);
            $item['image_url'] = 'http://hulk-img.chengnuozx.com/Fspe0NmsAcVGg_IHtj4lvEVqptt5';
            if (isset($resource_entity)) {
                $item['image_url'] = $resource_entity->url;
            }
            $items[] = $item;
        }
        return $items;
    }

    public function getCategoryAndAttributeInfo($id)
    {
        $data = [];
        $items = [];
        $category_repository = new CategoryRepository();
        $category_entity = $category_repository->fetch($id);
        if (isset($category_entity)) {
            $data = $category_entity->toArray();
            if ($data['category_attributes']) {
                $attribute_repository = new AttributeRepository();
                foreach ($data['category_attributes'] as $key => $name) {
                    /** @var AttributeEntity $attribute_entity */
                    $attribute_entity = $attribute_repository->fetch($key);
                    $item['id'] = $attribute_entity->id;
                    $item['name'] = $attribute_entity->name;
                    $item['attribute_values'] = $attribute_entity->attribute_values;
                    $items[$attribute_entity->id] = $item;
                }
            }
        }
        $attributes['id'] = $data['id'];
        $attributes['name'] = $data['name'];
        $attributes['category_attributes'] = $items;
        $attributes['categoryParams'] = $data['category_params'];
        return $attributes;
    }
}

