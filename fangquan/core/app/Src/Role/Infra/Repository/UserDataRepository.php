<?php namespace App\Src\Role\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Role\Domain\Interfaces\UserDataInterface;
use App\Src\Role\Domain\Model\UserDataEntity;
use App\Src\Role\Domain\Model\UserEntity;
use App\Src\Role\Infra\Eloquent\UserDataModel;


class UserDataRepository extends Repository implements UserDataInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param UserDataEntity $user_data_entity
     */
    protected function store($user_data_entity)
    {
        if ($user_data_entity->isStored()) {
            $model = UserDataModel::find($user_data_entity->id);
        } else {
            $model = new UserDataModel();
        }
        $model->fill(
            [
                'user_id'   => $user_data_entity->user_id,
                'data_id'   => $user_data_entity->data_id,
                'data_type' => $user_data_entity->data_type,
            ]
        );
        $model->save();
        $user_data_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return \App\Src\Role\Domain\Model\UserDataEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = UserDataModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return \App\Src\Role\Domain\Model\UserEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new UserEntity();
        $entity->id = $model->id;
        $entity->user_id = $model->user_id;
        $entity->data_id = $model->data_id;
        $entity->data_type = $model->data_type;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param int $user_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getUserDataByUserId($user_id)
    {
        $collect = collect();
        $builder = UserDataModel::query();
        $builder->where('user_id', $user_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


    /**
     * @param int $user_id
     */
    public function deleteByUserId($user_id)
    {
        $builder = UserDataModel::query();
        $builder->where('user_id', $user_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }


}