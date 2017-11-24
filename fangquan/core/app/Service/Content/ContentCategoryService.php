<?php

namespace App\Service\Content;


use App\Src\Content\Domain\Model\ContentCategoryEntity;
use App\Src\Content\Domain\Model\ContentCategorySpecification;
use App\Src\Content\Domain\Model\ContentCategoryStatus;
use App\Src\Content\Infra\Repository\ContentCategoryRepository;

class ContentCategoryService
{
    public function getMainContentCategoryList()
    {
        $data = [];
        $content_category_repository = new ContentCategoryRepository();
        $content_category_entities = $content_category_repository->ContentFirstCategory();
        /** @var ContentCategoryEntity $content_category_entity */
        foreach ($content_category_entities as $content_category_entity) {
            $item = $content_category_entity->toArray();
            $content_category_status = ContentCategoryStatus::acceptableEnums();
            $item['status_name'] = $content_category_status[$item['status']] ?? '';
            $data[] = $item;
        }
        return $data;
    }

    /**
     * @param int $parent_id
     * @param int $status
     * @return array
     */
    public function getContentCategoryByParentId($parent_id)
    {
        $data = [];
        $content_category_repository = new ContentCategoryRepository();
        $content_category_entities = $content_category_repository->getContentCategoryByParentId($parent_id);
        /** @var ContentCategoryEntity $content_category_entity */
        foreach ($content_category_entities as $content_category_entity) {
            $item = $content_category_entity->toArray();
            $content_category_status = ContentCategoryStatus::acceptableEnums();
            $item['status_name'] = $content_category_status[$item['status']] ?? '';
            $data[] = $item;
        }
        return $data;
    }


    /**
     * @param $id
     * @return array
     *
     */
    public function getContentCategoryInfo($id)
    {
        $data = [];
        $content_category_status = ContentCategoryStatus::acceptableEnums();
        $content_category_repository = new ContentCategoryRepository();
        /** @var ContentCategoryEntity $content_category_entity */
        $content_category_entity = $content_category_repository->fetch($id);
        if (isset($content_category_entity)) {
            $data = $content_category_entity->toArray();
            $data['category_status'] = $content_category_status;
        }
        return $data;
    }

    /**
     * 获取供应商1级分类
     * @param $status
     * @return array
     */
    public function getProviderMainCategoryList($status)
    {
        $content_category_repository = new ContentCategoryRepository();
        $paginate = $content_category_repository->allContentCategory($status);
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

    public function getContentCategoryTree()
    {
        $data = [];
        $content_category_repository = new ContentCategoryRepository();
        $content_category_entities = $content_category_repository->allContentCategory(ContentCategoryStatus::STATUS_ONLINE);
        foreach ($content_category_entities as $content_category_entity) {
            $data[$content_category_entity->id] = $content_category_entity->toArray();
        }
        $result = [];
        $trees = $this->getTree($data);
        $result = $this->getLineTree($trees);

        return $result;
    }


    protected function getTree($items)
    {
        $tree = array();
        foreach ($items as $item) {
            if (!empty($items[$item['parent_id']])) {
                $items[$item['parent_id']]['nodes'][] = &$items[$item['id']];
            } else {
                $tree[] = &$items[$item['id']];
            }
        }
        return $tree;
    }

    protected function getLineTree($items, &$tree = [], $deep = 0, $separator = '--&nbsp;')
    {
        $deep++;
        foreach ($items as $item) {
            $item['name'] = str_repeat($separator, $deep - 1) . $item['name'];
            $tree[$item['id']] = $item;
            if (isset($item['nodes'])) {
                $this->getLineTree($item['nodes'], $tree, $deep, $separator);
            }
        }
        return $tree;
    }
}

