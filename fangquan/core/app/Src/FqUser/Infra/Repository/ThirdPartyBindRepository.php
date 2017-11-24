<?php namespace App\Src\FqUser\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\FqUser\Domain\Interfaces\ThirdPartyBindInterface;
use App\Src\FqUser\Domain\Model\ThirdPartyBindEntity;
use App\Src\FqUser\Domain\Model\ThirdPartyBindSpecification;
use App\Src\FqUser\Infra\Eloquent\ThirdPartyBindModel;

class ThirdPartyBindRepository extends Repository implements ThirdPartyBindInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  ThirdPartyBindEntity $third_party_bind_entity
     */
    protected function store($third_party_bind_entity)
    {
        if ($third_party_bind_entity->isStored()) {
            $model = ThirdPartyBindModel::find($third_party_bind_entity->id);
        } else {
            $model = new ThirdPartyBindModel();
        }
        $model->fill(
            [
                'third_type' => $third_party_bind_entity->third_type,
                'open_id'    => $third_party_bind_entity->open_id,
                'user_id'    => $third_party_bind_entity->user_id,
            ]
        );
        $model->save();
        $third_party_bind_entity->setIdentity($model->id);
    }


    public function search(ThirdPartyBindSpecification $spec, $per_page = 20)
    {
        $builder = ThirdPartyBindModel::query();
        $builder->orderByDesc('created_at');

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
     * @param $id
     * @return array|\Illuminate\Support\Collection
     */
    public function getFqUserById($id)
    {
        $collect = collect();
        $builder = ThirdPartyBindModel::query();
        $builder->where('id', $id);
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    public function getThirdPartyByOpenId($open_id)
    {
        $builder = ThirdPartyBindModel::query();
        $builder->where('open_id', $open_id);
        $model = $builder->first();
        if (isset($model)) {
            return $this->reconstituteFromModel($model)->stored();
        }
        return null;
    }

    /**
     * @param $id
     * @return mixed|void
     */
    public function delete($id)
    {
        $builder = ThirdPartyBindModel::query();
        $builder->whereIn('id', (array)$id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @param $third_type
     * @param $open_id
     * @return mixed
     */
    public function getThirdPartyBindByThirdTypeAndOpenId($third_type, $open_id)
    {
        $builder = ThirdPartyBindModel::query();
        $builder->where('third_type', $third_type);
        $builder->where('open_id', $open_id);
        $model = $builder->first();
        return $model;
    }


    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return ThirdPartyBindEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ThirdPartyBindModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ThirdPartyBindModel $model
     * @return ThirdPartyBindEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ThirdPartyBindEntity();
        $entity->id = $model->id;
        $entity->third_type = $model->third_type;
        $entity->open_id = $model->open_id;
        $entity->user_id = $model->user_id;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }
}
