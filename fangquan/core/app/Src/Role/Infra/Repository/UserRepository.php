<?php namespace App\Src\Role\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Role\Domain\Interfaces\UserInterface;
use App\Src\Role\Domain\Model\UserEntity;
use App\Src\Role\Domain\Model\UserSearchType;
use App\Src\Role\Domain\Model\UserSpecification;
use App\Src\Role\Infra\Eloquent\UserModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class UserRepository extends Repository implements UserInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param UserEntity $user_entity
     */
    protected function store($user_entity)
    {
        if ($user_entity->isStored()) {
            $model = UserModel::find($user_entity->id);
        } else {
            $model = new UserModel();
        }
        //密码单独处理

        $model->fill(
            [
                'account'         => $user_entity->account,
                'company_id'      => $user_entity->company_id,
                'company_name'    => $user_entity->company_name,
                'employee_id'     => $user_entity->employee_id,
                'position'        => $user_entity->position,
                'name'            => $user_entity->name,
                'email'           => $user_entity->email,
                'phone'           => $user_entity->phone,
                'status'          => $user_entity->status,
                'type'            => $user_entity->type,
                'created_user_id' => $user_entity->created_user_id,
            ]
        );
        $model->save();
        if (isset($user_entity->role_ids)) {
            $model->roles()->sync($user_entity->role_ids);
        }
        if (isset($user_entity->depart_ids)) {
            $model->departs()->sync($user_entity->depart_ids);
        }
        $user_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return \App\Src\Role\Domain\Model\UserEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = UserModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $employee_id
     * @return mixed|string
     */
    public function getUserByEmployee($employee_id)
    {
        return UserModel::where('employee_id', $employee_id)->first();
    }

    /**
     * @param $model
     * @return \App\Src\Role\Domain\Model\UserEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new UserEntity();
        $entity->id = $model->id;
        $entity->account = $model->account;
        $entity->company_id = $model->company_id;
        $entity->company_name = $model->company_name;
        $entity->employee_id = $model->employee_id;
        $entity->position = $model->position;
        $entity->name = $model->name;
        $entity->email = $model->email;
        $entity->phone = $model->phone;
        $entity->password = $model->password;
        $entity->status = $model->status;
        $entity->type = $model->type;
        $entity->remember_token = $model->remember_token;
        $entity->created_user_id = $model->created_user_id;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->role_ids = $model->roles->pluck('id')->toArray();
        $entity->depart_ids = $model->departs->pluck('id')->toArray();
        $entity->roles = $model->roles->toArray();
        $entity->departs = $model->departs->toArray();
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param UserSpecification $spec
     * @param int               $per_page
     * @return LengthAwarePaginator
     */
    public function search(UserSpecification $spec, $per_page = 10)
    {
        $builder = UserModel::query();
        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }

        $builder->orderBy('user.created_at', 'desc');

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
     * @param array $depart_ids
     * @return array|\Illuminate\Support\Collection
     */
    public function getUsersByDepartIds($depart_ids)
    {
        $collect = collect();
        $builder = UserModel::query();
        $builder->leftJoin('user_depart', function ($join) {
            $join->on('user_depart.user_id', '=', 'user.id');
        });
        $builder->whereIn('user_depart.depart_id', $depart_ids);
        $builder->select('user.*');
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param  array $ids
     * @return array|\Illuminate\Support\Collection
     */
    public function getUserByIds($ids)
    {
        $collect = collect();
        $builder = UserModel::query();
        $builder->whereIn('id', $ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


    /**
     * @var string|array $phone
     * @return array|\Illuminate\Support\Collection
     */
    public function getUserByPhone($phone)
    {
        $collect = collect();
        $builder = UserModel::query();
        if ($phone) {
            $builder->whereIn('phone', (array)$phone);
        }
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


    /**
     * @param string $account
     * @return array|\Illuminate\Support\Collection
     */
    public function getUserByAccount($account)
    {
        $collect = collect();
        $builder = UserModel::query();
        $builder->where('account', $account);
        $models = $builder->get();
        /** @var UserModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


    /**
     * @param int|array $ids
     */
    public function delete($ids)
    {
        $builder = UserModel::query();
        $builder->whereIn('id', (array)$ids);
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
        $collection = collect();
        $builder = UserModel::query();
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }

    /**
     * 修改密码
     * @param $user_entity
     */
    public function updatePassword($user_entity)
    {
        /** @var UserModel $model */
        $model = UserModel::find($user_entity->id);
        if (isset($model)) {
            $model->password = $model->getMd5Password($user_entity->password);
            $model->save();
        }
    }


    /**
     * @param int     $id
     * @param boolean $with_thread
     * @return UserEntity|null
     */
    public function getUserById($id, $with_trashed = false)
    {
        $builder = UserModel::query();
        if ($with_trashed) {
            $builder->withTrashed();
        }
        $model = $builder->find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }


    /**
     * @param  int $id
     */
    public function updateUploadNum($id)
    {
        /** @var UserEntity $entity */
        $entity = $this->fetch($id);
        if (isset($entity)) {
            $entity->upload_number = $entity->upload_number + 1;
            $this->save($entity);
        }
    }

    public function getUserByOpenId($openid)
    {
        $builder = UserModel::query();
        $builder->leftJoin('third_party_bind', function ($join) {
            $join->on('user.id', '=', 'third_party_bind.user_id');
        });
        $builder->where('third_party_bind.open_id', $openid);
        $builder->select('user.*');
        $model = $builder->first();
        /** @var UserModel $model */
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }
}