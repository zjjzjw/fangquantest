<?php namespace App\Src\Advertisement\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Advertisement\Domain\Interfaces\AdvertisementInterface;
use App\Src\Advertisement\Domain\Model\AdvertisementEntity;
use App\Src\Advertisement\Domain\Model\AdvertisementSpecification;
use App\Src\Advertisement\Domain\Model\AdvertisementStatus;
use App\Src\Advertisement\Infra\Eloquent\AdvertisementModel;

class AdvertisementRepository extends Repository implements AdvertisementInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  AdvertisementEntity $advertisement_entity
     */
    protected function store($advertisement_entity)
    {
        if ($advertisement_entity->isStored()) {
            $model = AdvertisementModel::find($advertisement_entity->id);
        } else {
            $model = new AdvertisementModel();
        }
        $model->fill(
            [
                'title'    => $advertisement_entity->title,
                'image_id' => $advertisement_entity->image_id,
                'position' => $advertisement_entity->position,
                'sort'     => $advertisement_entity->sort,
                'type'     => $advertisement_entity->type,
                'link'     => $advertisement_entity->link,
                'status'   => $advertisement_entity->status,
            ]
        );
        $model->save();
        $advertisement_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return AdvertisementEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = AdvertisementModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return AdvertisementEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new AdvertisementEntity();
        $entity->id = $model->id;
        $entity->title = $model->title;
        $entity->image_id = $model->image_id;
        $entity->position = $model->position;
        $entity->sort = $model->sort;
        $entity->link = $model->link;
        $entity->type = $model->type;
        $entity->status = $model->status;
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
    public function getAdvertisementList($limit)
    {
        $data = [];
        $builder = AdvertisementModel::query();
        $builder->where('status', AdvertisementStatus::YES);
        $builder->limit($limit);
        $models = $builder->get();
        /** @var AdvertisementModel $model */
        foreach ($models as $model) {
            $data[] = $this->reconstituteFromModel($model)->stored();
        }
        return $data;

    }


    /**
     * @param AdvertisementSpecification $spec
     * @param int                        $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(AdvertisementSpecification $spec, $per_page = 10)
    {
        $builder = AdvertisementModel::query();

        if ($spec->keyword) {
            $builder->where('title', 'like', '%' . $spec->keyword . '%');
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
        $builder = AdvertisementModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * 根据类型获取广告
     * @param $type
     * @param $num
     * @return array|\Illuminate\Support\Collection
     */
    public function getAdvertisementForType($type, $num)
    {
        $collect = collect();

        $builder = AdvertisementModel::query();
        $builder->whereIn('type', (array)$type);
        $builder->orderByDesc('sort');
        $builder->limit($num);
        $models = $builder->get();

        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }

        return $collect;
    }
}