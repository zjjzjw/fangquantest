<?php

namespace App\Service\Category;


use App\Src\Category\Domain\Model\AttributeEntity;
use App\Src\Category\Domain\Model\AttributeSpecification;
use App\Src\Category\Infra\Repository\AttributeRepository;
use App\Src\Category\Infra\Repository\CategoryRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class AttributeService
{
    /**
     * @param AttributeSpecification $spec
     * @param int                    $per_page
     * @return array
     */
    public function getAttributeList(AttributeSpecification $spec, $per_page)
    {
        $data = [];
        $attribute_repository = new AttributeRepository();
        $category_repository = new CategoryRepository();
        $paginate = $attribute_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var int                  $key
         * @var AttributeEntity      $attribute_entity
         * @var LengthAwarePaginator $paginate
         */

        foreach ($paginate as $key => $attribute_entity) {
            $item = $attribute_entity->toArray();
            $category_entity = $category_repository->fetch($attribute_entity->category_id);
            $item['category_name'] = $category_entity->name ?? '';
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
    public function getAttributeInfo($id)
    {
        $data = [];
        $attribute_repository = new AttributeRepository();
        /** @var AttributeEntity $attribute_entity */
        $attribute_entity = $attribute_repository->fetch($id);
        if (isset($attribute_entity)) {
            $data = $attribute_entity->toArray();
        }
        return $data;
    }

    /**
     * 得到所有的属性
     * @return array
     */
    public function getAttributeLists()
    {
        $data = [];
        $attribute_repository = new AttributeRepository();
        $attribute_entities = $attribute_repository->all();
        foreach ($attribute_entities as $attribute_entity) {
            $item = $attribute_entity->toArray();
            $data[] = $item;
        }
        return $data;
    }


    /**
     * @param int $category_id
     * @return array
     */
    public function getAttributeByCategoryId($category_id)
    {
        $data = [];
        $attribute_repository = new AttributeRepository();
        $attribute_entities = $attribute_repository->getAttributeByCategoryId($category_id);
        foreach ($attribute_entities as $attribute_entity) {
            $item = $attribute_entity->toArray();
            $data[] = $item;
        }
        return $data;
    }
}

