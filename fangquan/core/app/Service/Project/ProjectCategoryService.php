<?php

namespace App\Service\Project;


use App\Src\Project\Domain\Model\ProjectCategoryEntity;
use App\Src\Project\Domain\Model\ProjectCategorySpecification;
use App\Src\Project\Domain\Model\ProjectCategoryStatus;
use App\Src\Project\Infra\Repository\ProjectCategoryRepository;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderSpecification;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectCategoryService
{
    public function getAllDeveloperCategoryTreeList()
    {
        $items = [];
        $project_category_repository = new ProjectCategoryRepository();
        $project_category_entities = $project_category_repository->allProjectCategory();
        /** @var ProjectCategoryEntity $project_category_entity */
        foreach ($project_category_entities as $project_category_entity) {
            $item = $project_category_entity->toArray();
            $product_category_status = ProjectCategoryStatus::acceptableEnums();
            $item['status_name'] = $product_category_status[$item['status']] ?? '';
            $items[$item['id']] = $item;
        }
        $project_category_service = new ProjectCategoryService();

        $data = $project_category_service->getTree($items);

        return $data;
    }


    /**
     * 获取供应商主营分类
     * @param $status
     * @return array
     */
    public function getProjectCategoryMainList($status)
    {
        $project_category_repository = new ProjectCategoryRepository();
        $paginate = $project_category_repository->allProjectCategory($status);
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
    public function getThirdProjectCategoryList($second_ids, $status)
    {
        $items = [];
        $project_category_repository = new ProjectCategoryRepository();
        $project_category_entities = $project_category_repository->getThirdProjectCategory($second_ids, $status);

        foreach ($project_category_entities as $project_category_entity) {
            $item = $project_category_entity->toArray();
            $items[] = $item;
        }
        return $items;
    }

    /**
     * @param int $status
     * @return array
     */
    public function getProjectCategoryListByIdsAndLevel($second_ids, $status)
    {
        $items = [];
        $project_category_repository = new ProjectCategoryRepository();
        $project_category_entities = $project_category_repository->getProjectCategoryByIdsAndLevel($second_ids, $status);

        foreach ($project_category_entities as $project_category_entity) {
            $item = $project_category_entity->toArray();
            $items[] = $item;
        }
        return $items;
    }

    /**
     * @param $project_category_ids
     * @return array|string
     */
    public function getProjectCategoryNameByIds($project_category_ids)
    {
        $project_category_repository = new ProjectCategoryRepository();
        $project_category_models = $project_category_repository->getProjectCategoryByIds($project_category_ids);
        $project_category_names = [];
        foreach ($project_category_models as $project_category_model) {
            $project_category_names[] = $project_category_model->name;
        }
        $project_category_names = implode(',', $project_category_names);
        return $project_category_names;
    }


    public function getProjectCategoryByCategoryIds($project_category_ids)
    {
        $items = [];
        $project_category_repository = new ProjectCategoryRepository();
        $project_category_entities = $project_category_repository->getProjectCategoryByIds($project_category_ids);
        foreach ($project_category_entities as $project_category_entity) {
            $item = $project_category_entity->toArray();
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
    public function getProjectCategoryByLevel($level, $status)
    {
        $items = [];
        $project_category_repository = new ProjectCategoryRepository();
        $project_category_entities = $project_category_repository->getProjectCategoryByLevelAndStatus($level, $status);
        /** @var ProjectCategoryEntity $project_category_entity */
        foreach ($project_category_entities as $project_category_entity) {
            $item = $project_category_entity->toArray();
            $items[] = $item;
        }
        return $items;
    }

    /**
     * @param int $parent_id
     * @param int $status
     * @return array
     */
    public function getProjectCategoryByParentId($parent_id, $status)
    {
        $items = [];
        $project_category_repository = new ProjectCategoryRepository();
        $project_category_entities = $project_category_repository->getProjectCategoryByParentId($parent_id, $status);
        /** @var ProjectCategoryEntity $project_category_entity */
        foreach ($project_category_entities as $project_category_entity) {
            $item = $project_category_entity->toArray();
            $items[] = $item;
        }
        return $items;
    }

    /**
     * @param $id
     * @return array
     */
    public function getProjectCategoryInfo($id)
    {
        $data = [];
        $project_category_repository = new ProjectCategoryRepository();
        $resource_repository = new ResourceRepository();
        /** @var ProjectCategoryEntity $project_category_entity */
        $project_category_entity = $project_category_repository->fetch($id);
        if (isset($project_category_entity)) {
            $data = $project_category_entity->toArray();
            $data['attribfield_light'] = json_decode($project_category_entity->attribfield, true);
            //得到缩略图
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($project_category_entity->logo);
            if (isset($resource_entity)) {
                $data['thumbnail_url'] = $resource_entity->url;
                $thumbnail_images = [];
                $thumbnail_image = [];
                $thumbnail_image['image_id'] = $project_category_entity->logo;
                $thumbnail_image['url'] = $resource_entity->url;
                $thumbnail_images[] = $thumbnail_image;
                $data['thumbnail_images'] = $thumbnail_images;
                $data['image_url'] = $resource_entity->url;
            }
        }
        return $data;
    }

    protected function getTree($items)
    {
        $tree = array();
        foreach ($items as $key => $item) {
            if (!empty($items[$item['parent_id']])) {
                $items[$item['parent_id']]['nodes'][] = &$items[$item['id']];
                $items[$item['parent_id']]['node_ids'][] = &$items[$item['id']]['id'];
            } else {
                $tree[] = &$items[$item['id']];
            }
        }
        return $tree;
    }

}

