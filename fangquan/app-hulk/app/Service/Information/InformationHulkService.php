<?php

namespace App\Hulk\Service\Information;


use App\Src\Category\Domain\Model\CategoryEntity;
use App\Src\Category\Infra\Repository\CategoryRepository;
use App\Src\Information\Domain\Model\InformationEntity;
use App\Src\Information\Domain\Model\InformationSpecification;
use App\Src\Information\Infra\Repository\InformationRepository;
use App\Src\Product\Domain\Model\ProductStatus;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use App\Src\Tag\Domain\Model\TagEntity;
use App\Src\Tag\Infra\Repository\TagRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class InformationHulkService
{
    /**
     * @param InformationSpecification $spec
     * @param int                      $per_page
     * @return array
     */
    public function getInformationList(InformationSpecification $spec, $per_page)
    {
        $data = [];
        $information_repository = new InformationRepository();
        $tag_repository = new TagRepository();
        $resource_repository = new ResourceRepository();
        $paginate = $information_repository->search($spec, $per_page);
        $items = [];

        /**
         * @var int                  $key
         * @var InformationEntity    $information_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $information_entity) {
            $item = [];
            $item['id'] = $information_entity->id;
            $item['title'] = $information_entity->title;
            $item['tag_id'] = $information_entity->tag_id;
            $item['tag_name'] = '';
            if (!empty($information_entity->tag_id)) {
                /** @var TagEntity $tag_entity */
                $tag_entity = $tag_repository->fetch($information_entity->tag_id);
                if (isset($tag_entity)) {
                    $item['tag_name'] = $tag_entity->name;
                }
            }
            $item['image'] = '';
            if (!empty($information_entity->thumbnail)) {
                /** @var ResourceEntity $thumbnail_entity */
                $thumbnail_entity = $resource_repository->fetch($information_entity->thumbnail);
                if (isset($thumbnail_entity)) {
                    $item['image'] = $thumbnail_entity->url;
                }
            }
            $items[] = $item;
        }
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
    public function getInformationInfo($id)
    {
        $data = [];
        $information_repository = new InformationRepository();
        /** @var InformationEntity $information_entity */
        $information_entity = $information_repository->fetch($id);
        if (isset($information_entity)) {
            $item = $information_entity->toArray();
            $data['id'] = $item['id'];
            $data['title'] = $item['title'];
            $data['publish_at'] = $item['publish_at'];
            $data['content'] = $item['content'];
            $data['author'] = $item['author'];
        }
        return $data;
    }

    public function getInformationListByCategoryId($category_id, $limit)
    {
        $items = [];
        $information_repository = new InformationRepository();
        $resource_repository = new ResourceRepository();
        $category_repository = new CategoryRepository();
        $tag_repository = new TagRepository();
        $information_entities = $information_repository->getInformationListByCategoryId($category_id, $limit, ProductStatus::YES);
        /** @var InformationEntity $information_entity */
        foreach ($information_entities as $information_entity) {
            $information_entity->toArray();
            $item['id'] = $information_entity->id;
            $item['title'] = $information_entity->title;
            /** @var ResourceEntity $thumbnail_entity */
            $thumbnail_entity = $resource_repository->fetch($information_entity->thumbnail);
            if (isset($thumbnail_entity)) {
                $item['image'] = $thumbnail_entity->url;
            }
            $item['tag_id'] = $information_entity->tag_id;
            if (!empty($information_entity->tag_id)) {
                /** @var TagEntity $tag_entity */
                $tag_entity = $tag_repository->fetch($information_entity->tag_id);
                if (isset($tag_entity)) {
                    $item['tag_name'] = $tag_entity->name;
                }
            }
            $item['publish_time'] = time_ago($information_entity->publish_at);
            /** @var CategoryEntity $category_entity */
            $category_entity = $category_repository->fetch($category_id);
            $item['category_id'] = $category_id;
            $item['category_name'] = $category_entity->name;
            $items[] = $item;
        }
        return $items;
    }

    public function getInformationListByProductId($product_id, $category_id, $limit)
    {
        $items = [];
        $information_repository = new InformationRepository();
        $resource_repository = new ResourceRepository();
        $category_repository = new CategoryRepository();
        $tag_repository = new TagRepository();
        $information_entities = $information_repository->getInformationListByProductId($product_id, $limit, ProductStatus::YES);
        /** @var InformationEntity $information_entity */
        foreach ($information_entities as $information_entity) {
            $information_entity->toArray();
            $item['id'] = $information_entity->id;
            $item['title'] = $information_entity->title;
            /** @var ResourceEntity $thumbnail_entity */
            $thumbnail_entity = $resource_repository->fetch($information_entity->thumbnail);
            if (isset($thumbnail_entity)) {
                $item['image'] = $thumbnail_entity->url;
            }
            $item['tag_id'] = $information_entity->tag_id;
            if (!empty($information_entity->tag_id)) {
                /** @var TagEntity $tag_entity */
                $tag_entity = $tag_repository->fetch($information_entity->tag_id);
                if (isset($tag_entity)) {
                    $item['tag_name'] = $tag_entity->name;
                }
            }
            $item['publish_time'] = time_ago($information_entity->publish_at);
            /** @var CategoryEntity $category_entity */
            $category_entity = $category_repository->fetch($category_id);
            $item['category_id'] = $category_id;
            $item['category_name'] = $category_entity->name;
            $items[] = $item;
        }
        return $items;
    }

    public function getInformationListByBrandId($brand_id)
    {
        $items = [];
        $information_repository = new InformationRepository();
        $resource_repository = new ResourceRepository();
        $tag_repository = new TagRepository();
        $information_entities = $information_repository->getInformationListByBrandId($brand_id, ProductStatus::YES);
        /** @var InformationEntity $information_entity */
        foreach ($information_entities as $information_entity) {
            $information_entity->toArray();
            $item['id'] = $information_entity->id;
            $item['title'] = $information_entity->title;
            /** @var ResourceEntity $thumbnail_entity */
            $thumbnail_entity = $resource_repository->fetch($information_entity->thumbnail);
            if (isset($thumbnail_entity)) {
                $item['image'] = $thumbnail_entity->url;
            }
            $item['publish_time'] = time_ago($information_entity->publish_at);
            /** @var TagEntity $tag_entity */
            $tag_entity = $tag_repository->fetch($information_entity->tag_id);
            $item['tag_time'] = $tag_entity->name ?? '';
            $items[] = $item;
        }
        return $items;
    }
}

