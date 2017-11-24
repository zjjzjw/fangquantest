<?php

namespace App\Service\ContentPublish;


use App\Src\Content\Domain\Model\ContentCategoryEntity;
use App\Src\Content\Domain\Model\ContentEntity;
use App\Src\Content\Domain\Model\ContentSpecification;
use App\Src\Content\Domain\Model\ContentStatus;
use App\Src\Content\Domain\Model\ContentTimingPublishType;
use App\Src\Content\Infra\Repository\ContentCategoryRepository;
use App\Src\Content\Infra\Repository\ContentRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class ContentService
{
    /**
     * @param ContentSpecification $spec
     * @param int                  $per_page
     * @return array
     */
    public function getContentList(ContentSpecification $spec, $per_page)
    {
        $data = [];
        $content_repository = new ContentRepository();
        $resource_repository = new ResourceRepository();
        $content_category_repository = new ContentCategoryRepository();
        $paginate = $content_repository->search($spec, $per_page);
        $content_status = ContentStatus::acceptableEnums();
        $content_timing_publish_type = ContentTimingPublishType::acceptableEnums();
        $items = [];
        /**
         * @var int                  $key
         * @var ContentEntity        $content_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $content_entity) {
            $item = $content_entity->toArray();
            $item['status_name'] = $content_status[$content_entity->status];
            $item['timing_publish_name'] = $content_timing_publish_type[$content_entity->is_timing_publish];
            /** @var ContentCategoryEntity $content_category_entity */
            $content_category_entity = $content_category_repository->fetch($content_entity->type);
            if (isset($content_category_entity)) {
                $item['type_name'] = $content_category_entity->name;
            }
            $images = [];
            $image = [];
            $resource_entities = $resource_repository->getResourceUrlByIds(
                $content_entity->content_images
            );
            /** @var ResourceEntity $resource_entity */
            foreach ($resource_entities as $resource_entity) {
                $image['image_id'] = $resource_entity->id;
                $image['url'] = $resource_entity->url;
                $images[] = $image;
            }
            $item['publish_at'] = Carbon::parse($content_entity->publish_time)->format('Y.m.d');
            $item['thumbnail_images'] = $images;
            $item['images_count'] = count($images);
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
    public function getContentInfo($id)
    {
        $data = [];
        $content_repository = new ContentRepository();
        $resource_repository = new ResourceRepository();
        /** @var ContentEntity $content_entity */
        $content_entity = $content_repository->fetch($id);
        if (isset($content_entity)) {
            $data = $content_entity->toArray();
            $images = [];
            $image = [];
            $resource_entities = $resource_repository->getResourceUrlByIds(
                $content_entity->content_images
            );
            /** @var ResourceEntity $resource_entity */
            foreach ($resource_entities as $resource_entity) {
                $image['image_id'] = $resource_entity->id;
                $image['url'] = $resource_entity->url;
                $images[] = $image;
            }
            $data['thumbnail_images'] = $images;
            $audio_images = [];
            $audio_image = [];
            /** @var ResourceEntity $resource_audio_entity */
            $resource_audio_entity = $resource_repository->fetch($content_entity->audio);

            if (isset($resource_audio_entity)) {
                $audio_image['audio_id'] = $resource_audio_entity->id;
                $audio_image['audio_url'] = $resource_audio_entity->url;
                $audio_images[] = $audio_image;
            }
            $data['audio_images'] = $audio_images;
            $data['publish_at'] = Carbon::parse($content_entity->publish_time)->format('Y.m.d');
        }
        return $data;
    }

    public function getContentListByType($type, $limit = 0, $skip = 0)
    {
        $data = [];
        $content_repository = new ContentRepository();
        $resource_repository = new ResourceRepository();
        $content_category_repository = new ContentCategoryRepository();
        $content_entities = $content_repository->getContentByType($type, $limit, $skip);
        $content_status = ContentStatus::acceptableEnums();
        $content_timing_publish_type = ContentTimingPublishType::acceptableEnums();
        $items = [];
        $all_images = [];
        foreach ($content_entities as $key => $content_entity) {
            /** @var ContentEntity $item */
            $item = $content_entity->toArray();
            $item['status_name'] = $content_status[$content_entity->status];
            $item['timing_publish_name'] = $content_timing_publish_type[$content_entity->is_timing_publish];
            /** @var ContentCategoryEntity $content_category_entity */
            $content_category_entity = $content_category_repository->fetch($content_entity->type);
            if (isset($content_category_entity)) {
                $item['type_name'] = $content_category_entity->name;
            }
            $images = [];
            $image = [];
            $resource_entities = $resource_repository->getResourceUrlByIds(
                $content_entity->content_images
            );
            /** @var ResourceEntity $resource_entity */
            foreach ($resource_entities as $resource_entity) {
                $image['image_id'] = $resource_entity->id;
                $image['url'] = $resource_entity->url;
                $image['web_url'] = $content_entity->url;
                $images[] = $image;
                $all_images[] = $image;
            }

            $item['first_image'] = $images[0] ?? '';
            $audio_resource = $resource_repository->getResourceUrlByIds(
                $content_entity->audio
            );
            foreach ($audio_resource as $audio) {
                $item['audio_id'] = $audio->id;
                $item['audio_url'] = $audio->url;
            }
            $item['publish_at'] = Carbon::parse($content_entity->publish_time)->format('Y.m.d');
            $item['thumbnail_images'] = $images;
            $item['images_count'] = count($images);
            $items[] = $item;
        }
        $data['all_images'] = $all_images;
        $data['items'] = $items;

        return $data;
    }
}

