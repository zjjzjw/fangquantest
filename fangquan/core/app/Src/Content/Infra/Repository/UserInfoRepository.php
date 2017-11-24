<?php namespace App\Src\Content\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Content\Domain\Interfaces\UserInfoInterface;
use App\Src\Content\Domain\Model\UserInfoEntity;
use App\Src\Content\Infra\Eloquent\UserInfoModel;

class UserInfoRepository extends Repository implements UserInfoInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  UserInfoEntity $user_info_entity
     *
     */
    protected function store($user_info_entity)
    {
        if ($user_info_entity->isStored()) {
            $model = UserInfoModel::find($user_info_entity->id);
        } else {
            $model = new UserInfoModel();
        }
        $model->fill(
            [
                'user_id'  => $user_info_entity->user_id,
                'name'     => $user_info_entity->name,
                'company'  => $user_info_entity->company,
                'position' => $user_info_entity->position,
                'phone'    => $user_info_entity->phone,
                'email'    => $user_info_entity->email,
            ]
        );
        $model->save();
        $user_info_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return UserInfoEntity|null
     *
     */
    protected function reconstitute($id, $params = [])
    {
        $model = UserInfoModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return UserInfoEntity
     *
     */
    private function reconstituteFromModel($model)
    {
        $entity = new UserInfoEntity();
        $entity->id = $model->id;
        $entity->user_id = $model->user_id;
        $entity->name = $model->name;
        $entity->company = $model->company;
        $entity->phone = $model->phone;
        $entity->position = $model->position;
        $entity->email = $model->email;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param int|array $ids
     */
    public function delete($ids)
    {
        $builder = UserInfoModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }


    /**
     * @param int $user_id
     * @return UserInfoEntity|null
     */
    public function getUserInfoByUserId($user_id)
    {
        $builder = UserInfoModel::query();
        $builder->where('user_id', $user_id);
        $model = $builder->first();
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @return array|\Illuminate\Support\Collection
     */
    public function all()
    {
        $collect = collect();
        $builder = UserInfoModel::query();
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


}
