<?php namespace App\Src\MediaManagement\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\MediaManagement\Domain\Interfaces\MediaManagementInterface;
use App\Src\MediaManagement\Domain\Model\MediaManagementEntity;
use App\Src\MediaManagement\Domain\Model\MediaManagementSpecification;
use App\Src\MediaManagement\Domain\Model\MediaManagementType;
use App\Src\MediaManagement\Infra\Eloquent\MediaManagementModel;

class MediaManagementRepository extends Repository implements MediaManagementInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  MediaManagementEntity $MediaManagement_entity
     */
    protected function store($media_management_entity)
    {
        if ($media_management_entity->isStored()) {
            $model = MediaManagementModel::find($media_management_entity->id);
        } else {
            $model = new MediaManagementModel();
        }
        $model->fill(
            [
                'name'   => $media_management_entity->name,
                'logo'   => $media_management_entity->logo,
                'type' => $media_management_entity->type,
            ]
        );
        $model->save();
        $media_management_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return MediaManagementEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = MediaManagementModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return MediaManagementEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new MediaManagementEntity();
        $entity->id = $model->id;
        $entity->name = $model->name;
        $entity->logo = $model->logo;
        $entity->type = $model->type;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }


    /**
     * @param MediaManagementSpecification $spec
     * @param int                    $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(MediaManagementSpecification $spec, $per_page = 10)
    {
        $builder = MediaManagementModel::query();

        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }
        if ($spec->type) {
            $builder->where('status', $spec->type);
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
        $builder = MediaManagementModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }




    /**
     * @param int|array $status
     * @return array|\Illuminate\Support\Collection
     */
    public function getAllMediaManagementList($status)
    {
        $collect = collect();
        $builder = MediaManagementModel::query();
        $models = $builder->get();
        /** @var MediaManagementModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }



    public function getMediaManagementByKeyword($keyword)
    {
        $collect = collect();
        $builder = MediaManagementModel::query();
        $builder->where('name', 'like', '%' . $keyword . '%');
        $builder->limit(10);
        $models = $builder->get();
        /** @var MediaManagementModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }
}