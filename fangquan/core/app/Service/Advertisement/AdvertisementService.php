<?php

namespace App\Service\Advertisement;


use App\Src\Advertisement\Domain\Model\AdvertisementEntity;
use App\Src\Advertisement\Domain\Model\AdvertisementSpecification;
use App\Src\Advertisement\Domain\Model\AdvertisementStatus;
use App\Src\Advertisement\Infra\Repository\AdvertisementRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class AdvertisementService
{
    /**
     * @param AdvertisementSpecification $spec
     * @param int                        $per_page
     * @return array
     */
    public function getAdvertisementList(AdvertisementSpecification $spec, $per_page)
    {
        $data = [];
        $advertisement_repository = new AdvertisementRepository();
        $paginate = $advertisement_repository->search($spec, $per_page);
        $resource_repository = new ResourceRepository();
        $advertisement_status = AdvertisementStatus::acceptableEnums();
        $items = [];
        /**
         * @var int                  $key
         * @var AdvertisementEntity  $advertisement_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $advertisement_entity) {
            $item = $advertisement_entity->toArray();
            $resource_entity = $resource_repository->fetch($item['image_id']);
            $item['status_name'] = $advertisement_status[$item['status']];
            if (isset($resource_entity)) {
                $item['image_url'] = $resource_entity->url;
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
    public function getAdvertisementInfo($id)
    {
        $data = [];
        $advertisement_repository = new AdvertisementRepository();
        $resource_repository = new ResourceRepository();
        $advertisement_entity = $advertisement_repository->fetch($id);
        if (isset($advertisement_entity)) {
            $data = $advertisement_entity->toArray();
            //得到缩略图
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($advertisement_entity->image_id);
            if (isset($resource_entity)) {
                $data['thumbnail_url'] = $resource_entity->url;
                $thumbnail_images = [];
                $thumbnail_image = [];
                $thumbnail_image['image_id'] = $advertisement_entity->image_id;
                $thumbnail_image['url'] = $resource_entity->url;
                $thumbnail_images[] = $thumbnail_image;
                $data['thumbnail_images'] = $thumbnail_images;
                $data['image_url'] = $resource_entity->url;
            }
        }
        return $data;
    }

    public function getAdvertisementForType($type, $num = 10)
    {
        $data = [];
        $advertisement_repository = new AdvertisementRepository();

        $advertisement_entities = $advertisement_repository->getAdvertisementForType($type, $num);
        $resource_repository = new ResourceRepository();
        /**
         * @var int                  $key
         * @var AdvertisementEntity  $advertisement_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($advertisement_entities as $key => $advertisement_entity) {
            $item = $advertisement_entity->toArray();
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($item['image_id']);
            if (isset($resource_entity)) {
                $item['image_url'] = $resource_entity->url;
            }
            $data[] = $item;
        }

        return $data;
    }

}

