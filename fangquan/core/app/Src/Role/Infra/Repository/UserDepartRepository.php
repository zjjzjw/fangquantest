<?php namespace App\Src\Role\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Role\Domain\Interfaces\UserDepartInterface;
use App\Src\Role\Domain\Model\UserDepartEntity;
use App\Src\Role\Infra\Eloquent\UserDepartModel;


class UserDepartRepository extends Repository implements UserDepartInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param UserDepartEntity $user_depart_entity
     */
    protected function store($user_depart_entity)
    {
        if ($user_depart_entity->isStored()) {
            $model = UserDepartModel::find($user_depart_entity->id);
        } else {
            $model = new UserDepartModel();
        }
        $model->fill(
            [
                'user_id'   => $user_depart_entity->user_id,
                'depart_id' => $user_depart_entity->depart_id,
                'user'      => $user_depart_entity->user,
            ]
        );
        $model->save();
        $user_depart_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return \App\Src\Role\Domain\Model\UserDepartEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = UserDepartModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return \App\Src\Role\Domain\Model\UserDepartEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new UserDepartEntity();
        $entity->id = $model->id;
        $entity->user_id = $model->user_id;
        $entity->depart_id = $model->depart_id;
        $entity->user = $model->user;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }


    /**
     * @param int $depart_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getUserDepartByDepartId($depart_id)
    {
        $collect = collect();
        $builder = UserDepartModel::query();
        $builder->where('depart_id', $depart_id);
        $models = $builder->with('user')->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


}