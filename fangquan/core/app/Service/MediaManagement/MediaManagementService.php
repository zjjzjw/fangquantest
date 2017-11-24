<?php

namespace App\Service\MediaManagement;


use App\Src\MediaManagement\Domain\Model\MediaManagementType;
use App\Src\MediaManagement\Infra\Repository\MediaManagementRepository;
use App\Src\MediaManagement\Domain\Model\MediaManagementEntity;
use App\Src\MediaManagement\Domain\Model\MediaManagementSpecification;
use App\Src\Surport\Domain\Model\ResourceEntity;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Src\Surport\Infra\Repository\ResourceRepository;

class MediaManagementService
{
    /**
     * @param MediaManagementSpecification $spec
     * @param int                          $per_page
     * @return array
     */
    public function getMediaManagementList(MediaManagementSpecification $spec, $per_page)
    {
        $data = [];
        $media_management_repository = new MediaManagementRepository();
        $paginate = $media_management_repository->search($spec, $per_page);
        $resource_repository = new ResourceRepository();
        $media_management_type = MediaManagementType::acceptableEnums();
        $items = [];
        /**
         * @var int                   $key
         * @var MediaManagementEntity $media_management_entity
         * @var LengthAwarePaginator  $paginate
         */
        foreach ($paginate as $key => $media_management_entity) {
            $item = $media_management_entity->toArray();
            $resource_entity = $resource_repository->fetch($item['logo']);
            $item['type_name'] = $media_management_type[$item['type']];
            if (isset($resource_entity)) {
                $item['logo_url'] = $resource_entity->url;
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
    public function getMediaManagementInfo($id)
    {
        $data = [];
        $media_management_repository = new MediaManagementRepository();
        $resource_repository = new ResourceRepository();
        $media_management_entity = $media_management_repository->fetch($id);
        if (isset($media_management_entity)) {
            $data = $media_management_entity->toArray();
            //得到缩略图
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($media_management_entity->logo);
            if (isset($resource_entity)) {
                $data['thumbnail_url'] = $resource_entity->url;
                $thumbnail_images = [];
                $thumbnail_image = [];
                $thumbnail_image['image_id'] = $media_management_entity->logo;
                $thumbnail_image['url'] = $resource_entity->url;
                $thumbnail_images[] = $thumbnail_image;
                $data['thumbnail_images'] = $thumbnail_images;
                $data['image_url'] = $resource_entity->url;
            }
        }
        return $data;
    }

    public function getMediaManagementByType()
    {
        $data = [];
        $media_management_types = MediaManagementType::acceptableEnums();
        $media_management_repository = new MediaManagementRepository();
        $resource_repository = new ResourceRepository();
        $media_management_entities = $media_management_repository->getAllMediaManagementList(0);
        foreach ($media_management_types as $key => $management_type) {
            /** @var MediaManagementEntity $media_management_entity */
            foreach ($media_management_entities as $media_management_entity) {
                $item = $media_management_entity->toArray();
                //得到缩略图
                /** @var ResourceEntity $resource_entity */
                $resource_entity = $resource_repository->fetch($media_management_entity->logo);
                if (isset($resource_entity)) {
                    $item['thumbnail_url'] = $resource_entity->url;
                    $thumbnail_images = [];
                    $thumbnail_image = [];
                    $thumbnail_image['image_id'] = $media_management_entity->logo;
                    $thumbnail_image['url'] = $resource_entity->url;
                    $thumbnail_images[] = $thumbnail_image;
                    $item['thumbnail_images'] = $thumbnail_images;
                    $item['image_url'] = $resource_entity->url;
                }
                if ($media_management_entity->type == $key) {
                    $data[$key]['type_name'] = $management_type;
                    $data[$key]['list'][] = $item;
                }
            }
        }
        return $data;
    }
}

