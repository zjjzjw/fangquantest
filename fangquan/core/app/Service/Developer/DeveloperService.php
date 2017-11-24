<?php

namespace App\Service\Developer;


use App\Src\Developer\Domain\Model\DeveloperStatus;
use App\Src\Developer\Infra\Repository\DeveloperRepository;
use App\Src\Developer\Domain\Model\DeveloperEntity;
use App\Src\Developer\Domain\Model\DeveloperSpecification;
use App\Src\Surport\Domain\Model\ResourceEntity;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Src\Surport\Infra\Repository\ResourceRepository;


class DeveloperService
{


    /**
     * @param DeveloperSpecification $spec
     * @param int                    $per_page
     * @return array
     */

    public function getDeveloperList(DeveloperSpecification $spec, $per_page)
    {
        $data = [];
        $developer_repository = new DeveloperRepository();
        $paginate = $developer_repository->search($spec, $per_page);
        $resource_repository = new ResourceRepository();
        $developer_status = DeveloperStatus::acceptableEnums();
        $items = [];
        /**
         * @var int                  $key
         * @var DeveloperEntity      $developer_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $developer_entity) {
            $item = $developer_entity->toArray();
            $resource_entity = $resource_repository->fetch($item['logo']);
            $item['status_name'] = $developer_status[$item['status']] ?? '';
            //给一个默认图片
            $item['logo_url'] = '/www/images/provider/default_logo.png';
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

    public function getDeveloperListMore(DeveloperSpecification $spec, $per_page)
    {

        $data = [];
        $developer_repository = new DeveloperRepository();
        $paginate = $developer_repository->search($spec, $per_page);
        $resource_repository = new ResourceRepository();
        $developer_status = DeveloperStatus::acceptableEnums();
        $items = [];
        /**
         * @var int                  $key
         * @var DeveloperEntity      $developer_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $developer_entity) {
            $item = $developer_entity->toArray();
            $resource_entity = $resource_repository->fetch($item['logo']);
            $item['status_name'] = $developer_status[$item['status']] ?? '';
            //给一个默认图片
            $item['logo_url'] = '/www/images/provider/default_logo.png';
            if (isset($resource_entity)) {
                $item['logo_url'] = $resource_entity->url;
            }
            $items[] = $item;
        }
        $data['paginate'] = $paginate;
        $data['items'] = $items;
       return $data;
    }



    /**
     * @param $id
     * @return array
     */
    public function getDeveloperInfo($id)
    {
        $data = [];
        $developer_repository = new DeveloperRepository();
        $resource_repository = new ResourceRepository();
        /** @var DeveloperEntity $developer_entity */
        $developer_entity = $developer_repository->fetch($id);
        if (isset($developer_entity)) {
            $data = $developer_entity->toArray();
            //得到缩略图
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($developer_entity->logo);
            if (isset($resource_entity)) {
                $data['thumbnail_url'] = $resource_entity->url;
                $thumbnail_images = [];
                $thumbnail_image = [];
                $thumbnail_image['image_id'] = $developer_entity->logo;
                $thumbnail_image['url'] = $resource_entity->url;
                $thumbnail_images[] = $thumbnail_image;
                $data['thumbnail_images'] = $thumbnail_images;
                $data['image_url'] = $resource_entity->url;
            }
        }
        return $data;
    }


    public function getDevelopersByIds($ids)
    {
        $items = [];
        $developer_repository = new DeveloperRepository();
        $resource_repository = new ResourceRepository();
        $developer_entities = $developer_repository->getDevelopersByIds($ids);
        /** @var DeveloperEntity $developer_entity */
        foreach ($developer_entities as $developer_entity) {
            $item = $developer_entity->toArray();
            $item['logo_url'] = '/www/images/provider/default_logo.png';
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($developer_entity->logo);
            if (isset($resource_entity)) {
                $item['logo_url'] = $resource_entity->url;
            }
            $items[] = $item;
        }
        return $items;
    }

}

