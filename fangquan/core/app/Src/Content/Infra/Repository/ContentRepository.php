<?php namespace App\Src\Content\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Content\Domain\Interfaces\ContentInterface;
use App\Src\Content\Domain\Model\ContentEntity;
use App\Src\Content\Domain\Model\ContentSpecification;
use App\Src\Content\Domain\Model\ContentStatus;
use App\Src\Content\Infra\Eloquent\ContentImageModel;
use App\Src\Content\Infra\Eloquent\ContentModel;

class ContentRepository extends Repository implements ContentInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  ContentEntity $content_entity
     */
    protected function store($content_entity)
    {
        if ($content_entity->isStored()) {
            $model = ContentModel::find($content_entity->id);
        } else {
            $model = new ContentModel();
        }
        $model->fill(
            [
                'title'             => $content_entity->title,
                'author'            => $content_entity->author,
                'url'               => $content_entity->url,
                'audio'             => $content_entity->audio,
                'content'           => $content_entity->content,
                'remake'            => $content_entity->remake,
                'type'              => $content_entity->type,
                'is_timing_publish' => $content_entity->is_timing_publish,
                'publish_time'      => $content_entity->publish_time,
                'status'            => $content_entity->status,
                'audio_title'       => $content_entity->audio_title,
            ]
        );
        $model->save();
        if (isset($content_entity->content_images)) {
            $this->saveContentImages($model, $content_entity);
        }

        $content_entity->setIdentity($model->id);
    }


    /**
     * @param ContentModel  $model
     * @param ContentEntity $content_entity
     */
    protected function saveContentImages($model, $content_entity)
    {
        $content_image_models = $model->content_images;
        foreach ($content_image_models as $content_image_model) {
            $content_image_model->delete();
        }
        $items = [];
        if (!empty($content_entity->content_images)) {
            foreach ($content_entity->content_images as $image_id) {
                $items[] = new ContentImageModel(['image_id' => $image_id]);
            }
        }

        $model->content_images()->saveMany($items);
    }


    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return ContentEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ContentModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return ContentEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ContentEntity();
        $entity->id = $model->id;
        $entity->title = $model->title;
        $entity->author = $model->author;
        $entity->url = $model->url;
        $entity->audio = $model->audio;
        $entity->content = $model->content;
        $entity->remake = $model->remake;
        $entity->is_timing_publish = $model->is_timing_publish;
        $entity->publish_time = $model->publish_time;
        $entity->type = $model->type;
        $entity->status = $model->status;
        $entity->audio_title = $model->audio_title;
        $entity->content_images = $model->content_images->pluck('image_id')->toArray();
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param $limit
     * @return array
     */
    public function getContentList($limit)
    {
        $data = [];
        $builder = ContentModel::query();
        $builder->where('status', ContentStatus::YES);
        $builder->limit($limit);
        $models = $builder->get();
        /** @var ContentModel $model */
        foreach ($models as $model) {
            $data[] = $this->reconstituteFromModel($model)->stored();
        }
        return $data;

    }


    /**
     * @param ContentSpecification $spec
     * @param int                  $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ContentSpecification $spec, $per_page = 10)
    {
        $builder = ContentModel::query();

        if ($spec->keyword) {
            $builder->where('title', 'like', '%' . $spec->keyword . '%');
        }

        if ($spec->type) {
            $builder->where('type', $spec->type);
        }
        if ($spec->page) {
            $paginator = $builder->paginate($per_page, ['*'], 'page', $spec->page);
        } else {
            $paginator = $builder->paginate($per_page);
        }

        foreach ($paginator as $key => $model) {
            $paginator[$key] = $this->reconstituteFromModel($model)->stored();
        }

        return $paginator;
    }

    /**
     * @param int|array $ids
     */
    public function delete($ids)
    {
        $builder = ContentModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @param $type
     * @param $limit
     * @return array|\Illuminate\Support\Collection
     */
    public function getContentByType($type, $limit = 0, $skip)
    {
        $collect = collect();
        $builder = ContentModel::query();
        $builder->where('type', $type);
        if ($skip) {
            $builder->skip($skip);
        }
        $builder->where('status', ContentStatus::YES);
        if ($limit) {
            $builder->limit($limit);
        }
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }

        return $collect;
    }
}