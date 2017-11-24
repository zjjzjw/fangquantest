<?php namespace App\Src\Provider\Infra\Repository;

use App\Foundation\Domain\Repository;
use app\Src\Provider\Domain\Interfaces\ProviderCertificateInterface;
use app\Src\Provider\Domain\Interfaces\ProviderProjectPictureInterface;
use app\Src\Provider\Domain\Model\ProviderProjectPictureEntity;
use App\Src\Provider\Infra\Eloquent\ProviderProjectPictureModel;

class ProviderProjectPictureRepository extends Repository implements ProviderProjectPictureInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  ProviderProjectPictureEntity $provider_project_picture_entity
     */
    protected function store($provider_project_picture_entity)
    {
        if ($provider_project_picture_entity->isStored()) {
            $model = ProviderProjectPictureModel::find($provider_project_picture_entity->id);
        } else {
            $model = new ProviderProjectPictureModel();
        }
        $model->fill(
            [
                'provider_project_id' => $provider_project_picture_entity->provider_project_id,
                'image_id'            => $provider_project_picture_entity->image_id,
            ]
        );
        $model->save();
        $provider_project_picture_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return ProviderProjectPictureEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProviderProjectPictureModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return ProviderProjectPictureEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProviderProjectPictureEntity();
        $entity->id = $model->id;
        $entity->provider_project_id = $model->provider_project_id;
        $entity->image_id = $model->image_id;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param int $provider_project_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderProjectPictureByProjectId($provider_project_id)
    {
        $collect = collect();
        $builder = ProviderProjectPictureModel::query();
        $builder->where('provider_project_id', $provider_project_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param int|array $id
     */
    public function deleteById($id)
    {
        $builder = ProviderProjectPictureModel::query();
        $builder->whereIn('id', (array)$id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

}