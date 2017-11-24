<?php namespace App\Src\Provider\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Provider\Domain\Model\ProviderAduitdetailsEntity;
use App\Src\Provider\Domain\Model\ProviderAduitdetailsSpecification;
use App\Src\Provider\Domain\Model\ProviderSpecification;
use App\Src\Provider\Infra\Eloquent\ProviderAduitdetailsModel;


class ProviderAduitdetailsRepository extends Repository
{
    /**
     * Store an entity into persistence.
     *
     * @param  $provider_Aduitdetails_entity
     */
    protected function store($provider_Aduitdetails_entity)
    {
        if ($provider_Aduitdetails_entity->isStored()) {
            $model = ProviderAduitdetailsModel::find($provider_Aduitdetails_entity->id);
        } else {
            $model = new ProviderAduitdetailsModel();
        }
        $model->fill(
            [
                'id'          => $provider_Aduitdetails_entity->id,
                'provider_id' => $provider_Aduitdetails_entity->provider_id,
                'type'        => $provider_Aduitdetails_entity->type,
                'name'        => $provider_Aduitdetails_entity->name,
                'link'        => $provider_Aduitdetails_entity->link,
                'filename'    => $provider_Aduitdetails_entity->filename,

            ]
        );
        $model->save();
        $provider_Aduitdetails_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return \App\Src\Role\Domain\Model\UserFeedBackEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProviderAduitdetailsModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return \App\Src\Provider\Domain\Model\ProviderAduitdetailsEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProviderAduitdetailsEntity();
        $entity->id = $model->id;
        $entity->provider_id = $model->provider_id;
        $entity->type = $model->type;
        $entity->name = $model->name;
        $entity->link = $model->link;
        $entity->filename = $model->filename;
        $entity->created_at = $model->created_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }


    /**
     * @param ProviderAduitdetailsSpecification $spec
     * @return mixed
     */
    public function search(ProviderAduitdetailsSpecification $spec, $per_page = 20)
    {
        $builder = ProviderAduitdetailsModel::query();
        if ($spec->provider_id) {
            $builder->where('provider_id', $spec->provider_id);
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
     * @param array|int $id
     */
    public function delete($id)
    {
        $builder = ProviderAduitdetailsModel::query();
        $builder->whereIn('id', (array)$id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @return array|\Illuminate\Support\Collection
     */
    public function all()
    {
        $collect = collect();
        $builder = ProviderAduitdetailsModel::query();
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param int       $provider_id
     * @param           $type
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderAduitdetailsByProviderId($provider_id, $type = null)
    {
        $collect = collect();
        $builder = ProviderAduitdetailsModel::query();
        $builder->where('provider_id', $provider_id);
        if ($type) {
            $builder->where('type', (array)$type);
        }
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }

        return $collect;
    }


}