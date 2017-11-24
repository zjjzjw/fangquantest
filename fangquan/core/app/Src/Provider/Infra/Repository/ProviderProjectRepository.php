<?php namespace App\Src\Provider\Infra\Repository;

use App\Src\Provider\Domain\Interfaces\ProviderProjectInterface;
use App\Src\Provider\Domain\Model\ProviderProjectSpecification;
use App\Src\Provider\Infra\Eloquent\ProviderProjectModel;
use App\Src\Provider\Domain\Model\ProviderProjectEntity;
use App\Foundation\Domain\Repository;
use App\Src\Provider\Infra\Eloquent\ProviderProjectPictureModel;
use App\Src\Provider\Infra\Eloquent\ProviderProjectProductModel;

class ProviderProjectRepository extends Repository implements ProviderProjectInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  ProviderProjectEntity $provider_project_entity
     */
    protected function store($provider_project_entity)
    {
        if ($provider_project_entity->isStored()) {
            $model = ProviderProjectModel::find($provider_project_entity->id);
        } else {
            $model = new ProviderProjectModel();
        }
        $model->fill(
            [
                'provider_id'    => $provider_project_entity->provider_id,
                'name'           => $provider_project_entity->name,
                'developer_name' => $provider_project_entity->developer_name,
                'province_id'    => $provider_project_entity->province_id,
                'city_id'        => $provider_project_entity->city_id,
                'time'           => $provider_project_entity->time,
                'status'         => $provider_project_entity->status,
            ]
        );

        $model->save();
        $this->saveProviderProjectPictureAndProjectProduct($model, $provider_project_entity);
        $provider_project_entity->setIdentity($model->id);
    }

    public function search(ProviderProjectSpecification $spec, $per_page = 20)
    {
        $builder = ProviderProjectModel::query();
        if ($spec->provider_id) {
            $builder->where('provider_id', $spec->provider_id);
        }
        if ($spec->status) {
            $builder->where('status', $spec->status);
        }

        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }
        $builder->orderBy('created_at', 'desc');
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
     * @param ProviderProjectModel  $model
     * @param ProviderProjectEntity $provider_project_entity
     */
    public function saveProviderProjectPictureAndProjectProduct($model, $provider_project_entity)
    {
        $this->deleteProjectPictureAndProductById($model->getKey());

        if (isset($provider_project_entity->provider_project_picture_ids)) {
            foreach ($provider_project_entity->provider_project_picture_ids as $image_id) {
                $provider_project_picture_model = new ProviderProjectPictureModel();
                $provider_project_picture_model->image_id = $image_id;
                $provider_project_picture_model->provider_project_id = $model->getKey();
                $provider_project_picture_model->save();
            }
        }
        if (isset($provider_project_entity->provider_project_products)) {
            $model->provider_project_products()->createMany($provider_project_entity->provider_project_products);
        }
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return ProviderProjectEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProviderProjectModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProviderProjectModel $model
     * @return ProviderProjectEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProviderProjectEntity();
        $entity->id = $model->id;
        $entity->provider_id = $model->provider_id;
        $entity->name = $model->name;
        $entity->developer_name = $model->developer_name;
        $entity->province_id = $model->province_id;
        $entity->city_id = $model->city_id;
        $entity->time = $model->time;
        $entity->status = $model->status;
        $entity->provider_project_picture_ids = $model->provider_project_pictures->pluck('image_id')->toArray();
        $entity->provider_project_products = $model->provider_project_products->toArray();
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();

        return $entity;
    }

    /**
     * @param int $provider_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderProjectByProviderIdAndStatus($provider_id, $status)
    {
        $collect = collect();
        $builder = ProviderProjectModel::query();
        $builder->where('provider_id', $provider_id);
        if (!empty($status)) {
            $builder->whereIn('status', (array)$status);
        }
        $models = $builder->get();
        /** @var ProviderProjectModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param int|array $id
     */
    public function delete($id)
    {
        $builder = ProviderProjectModel::query();
        $builder->where('id', (array)$id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
        $this->deleteProjectPictureAndProductById($id);
    }

    public function deleteProjectPictureAndProductById($provider_project_id)
    {
        $this->deleteProjectPictureById($provider_project_id);
        $this->deleteProjectProductById($provider_project_id);
    }

    /**
     * 根据项目ID删除项目图片
     * @param $provider_project_id
     */
    public function deleteProjectPictureById($provider_project_id)
    {
        $builder = ProviderProjectPictureModel::query();
        $builder->where('provider_project_id', (array)$provider_project_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * 根据项目ID删除产品
     * @param $provider_project_id
     */
    public function deleteProjectProductById($provider_project_id)
    {
        $builder = ProviderProjectProductModel::query();
        $builder->where('provider_project_id', (array)$provider_project_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }
}