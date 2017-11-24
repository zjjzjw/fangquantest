<?php namespace App\Src\Provider\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Provider\Domain\Model\ProviderPropagandaEntity;
use App\Src\Provider\Domain\Model\ProviderPropagandaSpecification;
use App\Src\Provider\Domain\Model\ProviderSpecification;
use App\Src\Provider\Infra\Eloquent\ProviderPropagandaModel;


class ProviderPropagandaRepository extends Repository
{
    /**
     * Store an entity into persistence.
     *
     * @param ProviderPropagandaEntity $provider_Propaganda_entity
     */
    protected function store($provider_Propaganda_entity)
    {
        if ($provider_Propaganda_entity->isStored()) {
            $model = ProviderPropagandaModel::find($provider_Propaganda_entity->id);
        } else {
            $model = new ProviderPropagandaModel();
        }
        $model->fill(
            [
                'id'          => $provider_Propaganda_entity->id,
                'provider_id' => $provider_Propaganda_entity->provider_id,
                'image_id'    => $provider_Propaganda_entity->image_id,
                'link'        => $provider_Propaganda_entity->link,
                'status'      => $provider_Propaganda_entity->status,

            ]
        );
        $model->save();
        $provider_Propaganda_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return ProviderPropagandaEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProviderPropagandaModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return ProviderPropagandaEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProviderPropagandaEntity();
        $entity->id = $model->id;
        $entity->provider_id = $model->provider_id;
        $entity->image_id = $model->image_id;
        $entity->name = $model->name;
        $entity->link = $model->link;
        $entity->status = $model->status;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }


    /**
     * @param ProviderPropagandaSpecification $spec
     * @return mixed
     */
    public function search(ProviderPropagandaSpecification $spec, $per_page = 10)
    {
        $builder = ProviderPropagandaModel::query();
        if ($spec->provider_id) {
            $builder->where('provider_id', $spec->provider_id);
        }

        if ($spec->status) {
            $builder->where('status', $spec->status);
        }

        if ($spec->keyword) {
            //$builder->where('name', 'like', '%' . $spec->keyword . '%');
        }

        $builder->orderBy('id', 'desc');

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
        $builder = ProviderPropagandaModel::query();
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
        $builder = ProviderPropagandaModel::query();
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


    /**
     * @param  int      $provider_id
     * @param int|array $status
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderProviderPropagandaByProviderId($provider_id, $status)
    {
        $collect = collect();
        $builder = ProviderPropagandaModel::query();
        $builder->where('provider_id', $provider_id);
        $builder->where('status', (array)$status);
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


}