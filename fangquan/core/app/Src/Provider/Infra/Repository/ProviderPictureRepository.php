<?php namespace App\Src\Provider\Infra\Repository;


use App\Foundation\Domain\Repository;
use App\Src\Provider\Domain\Interfaces\ProviderPictureInterface;
use App\Src\Provider\Domain\Model\ProviderImageType;
use App\Src\Provider\Domain\Model\ProviderPictureEntity;
use App\Src\Provider\Domain\Model\ProviderPictureSpecification;
use App\Src\Provider\Infra\Eloquent\ProviderModel;
use App\Src\Provider\Infra\Eloquent\ProviderPictureModel;

class ProviderPictureRepository extends Repository implements ProviderPictureInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ProviderPictureEntity $provider_picture_entity
     */
    protected function store($provider_picture_entity)
    {
        if ($provider_picture_entity->isStored()) {
            $model = ProviderPictureModel::find($provider_picture_entity->id);
        } else {
            $model = new ProviderModel();
        }
        $model->fill(
            [
                'provider_id' => $provider_picture_entity->provider_id,
                'type'        => $provider_picture_entity->type,
                'image_id'    => $provider_picture_entity->image_id,
            ]
        );
        $model->save();
        $provider_picture_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return ProviderPictureEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProviderPictureModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProviderPictureModel $model
     *
     * @return ProviderPictureEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProviderPictureEntity();

        $entity->id = $model->id;
        $entity->provider_id = $model->provider_id;
        $entity->type = $model->type;
        $entity->image_id = $model->image_id;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();

        return $entity;
    }

    /**
     * @param ProviderPictureSpecification $spec
     * @param int                          $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ProviderPictureSpecification $spec, $per_page = 10)
    {
        $builder = ProviderPictureModel::query();
        if ($spec->column && $spec->sort) {
            $builder->orderBy($spec->column, $spec->sort);
        } else {
            $builder->orderBy('created_at', 'asc');
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
     * @param int $provider_id
     * @param     $type
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getImageByProviderId($provider_id, $type = null)
    {
        $builder = ProviderPictureModel::query();
        $builder->where('provider_id', $provider_id);
        if ($type) {
            $builder->where('type', $type);
        }
        $provider_picture = $builder->get();
        foreach ($provider_picture as $key => $model) {
            $provider_picture[$key] = $this->reconstituteFromModel($model)->stored();
        }
        return $provider_picture;

    }


    public function getLogoByProviderId($provider_id, $type = ProviderImageType::LOGO)
    {
        $builder = ProviderPictureModel::query();
        $builder->where('provider_id', $provider_id);
        $builder->where('type', $type);
        $provider_picture = $builder->first();
        if (isset($provider_picture)) {
            return $this->reconstituteFromModel($provider_picture)->stored();
        }
        return null;
    }

    /**
     * @param int|array $id
     */
    public function delete($id)
    {
        $builder = ProviderPictureModel::query();
        $builder->whereIn('id', (array)$id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

}