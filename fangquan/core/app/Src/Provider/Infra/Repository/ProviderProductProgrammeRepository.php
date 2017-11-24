<?php namespace App\Src\Provider\Infra\Repository;


use App\Foundation\Domain\Repository;
use App\Src\Provider\Domain\Interfaces\ProviderProductProgrammeInterface;
use App\Src\Provider\Domain\Model\ProviderProductProgrammeEntity;
use App\Src\Provider\Domain\Model\ProviderProductProgrammeSpecification;
use App\Src\Provider\Domain\Model\ProviderProductProgrammeStatus;
use App\Src\Provider\Domain\Model\ProviderProductProgrammeType;
use App\Src\Provider\Infra\Eloquent\ProviderProductProgrammeModel;
use App\Src\Provider\Infra\Eloquent\ProviderProductProgrammePictureModel;

class ProviderProductProgrammeRepository extends Repository implements ProviderProductProgrammeInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ProviderProductProgrammeEntity $provider_product_programme_entity
     */
    protected function store($provider_product_programme_entity)
    {
        if ($provider_product_programme_entity->isStored()) {
            $model = ProviderProductProgrammeModel::find($provider_product_programme_entity->id);
        } else {
            $model = new ProviderProductProgrammeModel();
        }
        $model->fill(
            [
                'title'       => $provider_product_programme_entity->title,
                'desc'        => $provider_product_programme_entity->desc,
                'status'      => $provider_product_programme_entity->status,
                'provider_id' => $provider_product_programme_entity->provider_id,
            ]
        );
        $model->save();
        if (isset($provider_product_programme_entity->product)) {
            $model->product()->sync($provider_product_programme_entity->product);
        }
        $this->saveProviderProductProgrammePicture($model, $provider_product_programme_entity);
        $provider_product_programme_entity->setIdentity($model->id);
    }

    /**
     * @param ProviderProductProgrammeModel  $model
     * @param ProviderProductProgrammeEntity $provider_product_programme_entity
     */
    public function saveProviderProductProgrammePicture($model, $provider_product_programme_entity)
    {
        $this->deleteProductProgrammePictureById($model->getKey());

        if (isset($provider_product_programme_entity->provider_product_programme_pictures)) {
            foreach ($provider_product_programme_entity->provider_product_programme_pictures as $image_id) {
                $provider_product_programme_picture_model = new ProviderProductProgrammePictureModel();
                $provider_product_programme_picture_model->programme_id = $model->getKey();
                $provider_product_programme_picture_model->image_id = $image_id;
                $provider_product_programme_picture_model->save();
            }
        }
    }

    public function deleteProductProgrammePictureById($provider_product_programme_id)
    {
        $builder = ProviderProductProgrammePictureModel::query();
        $builder->where('programme_id', (array)$provider_product_programme_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->forceDelete();
        }
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return ProviderProductProgrammeEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProviderProductProgrammeModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProviderProductProgrammeModel $model
     *
     * @return ProviderProductProgrammeEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProviderProductProgrammeEntity();

        $entity->id = $model->id;

        $entity->status = $model->status;
        $entity->title = $model->title;
        $entity->desc = $model->desc;
        $entity->product = $model->product()->pluck('product_id')->toArray();
        $entity->provider_product_programme_pictures = $model->provider_product_programme_pictures()->pluck('image_id')->toArray();
        $entity->provider_id = $model->provider_id;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;

        $entity->setIdentity($model->id);
        $entity->stored();

        return $entity;
    }

    /**
     * @param ProviderProductProgrammeSpecification $spec
     * @param int                                   $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ProviderProductProgrammeSpecification $spec, $per_page = 10)
    {
        $builder = ProviderProductProgrammeModel::query();

        if ($spec->provider_id) {
            $builder->where('provider_product_programme.provider_id', $spec->provider_id);
        }

        if ($spec->status) {
            $builder->where('provider_product_programme.status', $spec->status);
        }

        if ($spec->keyword) {
            $builder->where('provider_product_programme.title', 'like', '%' . $spec->keyword . '%');
        }

        if ($spec->user_id) {
            $builder->leftJoin('product_programme_favorite', function ($join) {
                $join->on('provider_product_programme.id', '=', 'product_programme_favorite.product_programme_id');
                $join->whereRaw('product_programme_favorite.deleted_at is NULL');
            });
            $builder->where('product_programme_favorite.user_id', $spec->user_id);
        }
        $builder->select('provider_product_programme.*');

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
     * @param $provider_id
     * @return array
     */
    public function getProviderProductProgrammeByProviderId($provider_id)
    {
        $data = [];
        $builder = ProviderProductProgrammeModel::query();
        $builder->where('status', ProviderProductProgrammeStatus::STATUS_PASS);
        $builder->where('provider_id', $provider_id);
        $models = $builder->get();
        /** @var ProviderProductProgrammeModel $model */
        foreach ($models as $model) {
            $data[] = $this->reconstituteFromModel($model)->stored();
        }
        return $data;
    }

    /**
     * @param      $ids
     * @param null $status
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderProductProgrammesByIds($ids, $status = null)
    {
        $collect = collect();
        $builder = ProviderProductProgrammeModel::query();
        $builder->whereIn('id', (array)$ids);
        if (!empty($status)) {
            $builder->where('status', (array)$status);
        }
        $models = $builder->get();
        /** @var ProviderProductProgrammeModel $model */
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
        $builder = ProviderProductProgrammeModel::query();
        $builder->whereIn('id', (array)$id);
        $models = $builder->get();
        foreach ($models as $model) {
            $provider_product_programme_entity = $this->reconstitute($model->id);
            if (!empty($provider_product_programme_entity->product)) {
                $model->product()->detach($provider_product_programme_entity->product);
            }
            $model->delete();
        }
        $this->deleteProductProgrammePictureById($id);
    }

}