<?php namespace App\Src\FqUser\Infra\Repository;

use App\Foundation\Domain\Repository;

use App\Src\FqUser\Domain\Interfaces\FqUserInterface;
use App\Src\FqUser\Domain\Model\FqUserAccountStatus;
use App\Src\Developer\Infra\Eloquent\DeveloperModel;
use App\Src\FqUser\Domain\Model\FqUserPlatformType;
use App\Src\FqUser\Domain\Model\FqUserSpecification;
use App\Src\Provider\Infra\Eloquent\ProviderModel;
use App\Src\FqUser\Domain\Model\FqUserRoleType;
use App\Src\FqUser\Infra\Eloquent\FqUserModel;
use App\Src\FqUser\Domain\Model\FqUserEntity;
use App\Src\FqUser\Domain\Model\FqUserStatus;


class FqUserRepository extends Repository implements FqUserInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  FqUserEntity $fq_user_entity
     */
    protected function store($fq_user_entity)
    {
        if ($fq_user_entity->isStored()) {
            $model = FqUserModel::find($fq_user_entity->id);
        } else {
            $model = new FqUserModel();
        }

        $model->fill(
            [
                'nickname'         => $fq_user_entity->nickname,
                'mobile'           => $fq_user_entity->mobile,
                'email'            => $fq_user_entity->email,
                'account'          => $fq_user_entity->account,
                'account_type'     => $fq_user_entity->account_type,
                'role_type'        => $fq_user_entity->role_type,
                'role_id'          => $fq_user_entity->role_id,
                'platform_id'      => $fq_user_entity->platform_id,
                'register_type_id' => $fq_user_entity->register_type_id,
                'avatar'           => $fq_user_entity->avatar,
                'project_area'     => $fq_user_entity->project_area,
                'project_category' => $fq_user_entity->project_category,
                'admin_id'         => $fq_user_entity->admin_id,
                'reg_time'         => $fq_user_entity->reg_time,
                'expire'           => $fq_user_entity->expire,
                'password'         => $fq_user_entity->password,
                'status'           => $fq_user_entity->status,
                'salt'             => $fq_user_entity->salt,
            ]
        );
        $model->save();
        $fq_user_entity->setIdentity($model->id);

    }


    public function search(FqUserSpecification $spec, $per_page = 20)
    {
        $builder = FqUserModel::query();

        if ($spec->keyword) {
            $builder->where(function ($query) use ($spec) {
                $query->where('mobile', 'like', '%' . $spec->keyword . '%')
                    ->orWhere('account', 'like', '%' . $spec->keyword . '%');
            });
        }
        if ($spec->account_type) {
            $builder->where('account_type', $spec->account_type);
        }
        if ($spec->provider_id) {
            $builder->where('role_id', $spec->provider_id);
        }
        if ($spec->platform_id) {
            $builder->where('platform_id', $spec->platform_id);
        }
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
        $builder = FqUserModel::query();
        $builder->where('id', $id);
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param $phone
     * @return bool
     */
    public function getFqUserByPhone($phone)
    {
        $builder = FqUserModel::query();
        $builder->where('mobile', $phone);
        $model = $builder->first();
        if ($model) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * @param $mobile
     * @return mixed
     */
    public function getFqUserByMobile($mobile)
    {
        $builder = FqUserModel::query();
        $builder->where('mobile', $mobile);
        $model = $builder->first();
        if (empty($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model)->stored();
    }


    /**
     * @param $account
     * @return mixed
     */
    public function getUserByAccount($account)
    {
        $collect = collect();
        $builder = FqUserModel::query();
        $builder->where('account', $account);
        $models = $builder->get();
        /** @var FqUserModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    public function getFqUsersByMobile($mobile)
    {
        $collect = collect();
        $builder = FqUserModel::query();
        $builder->where('mobile', 'like', '%' . $mobile . '%');
        $builder->limit(10);
        $models = $builder->get();
        /** @var FqUserModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param $account
     * @param $account_type
     * @return string
     */
    public function findSalt($account, $account_type)
    {
        $builder = FqUserModel::query();
        if ($account_type == FqUserAccountStatus::TYPE_EMAIL) {
            $builder->where('email', $account);
        } elseif ($account_type == FqUserAccountStatus::TYPE_MOBILE) {
            $builder->where('mobile', $account);
        } else {
            $builder->where('account', $account);
        }
        $model = $builder->first();
        if ($model) {
            return $model->salt;
        } else {
            return "";
        }
    }

    /**
     * @param string  $account
     * @param integer $account_type
     * @param string  $password
     * @param string  $plat_form
     * @return mixed|null
     */
    public function getFqUserModel($account, $account_type, $password, $plat_form = null)
    {
        $model = null;
        $salt = $this->findSalt($account, $account_type);
        $builder = FqUserModel::query();
        if ($salt) {
            if ($account_type == FqUserAccountStatus::TYPE_EMAIL) {
                $builder->where('email', $account);
            } elseif ($account_type == FqUserAccountStatus::TYPE_MOBILE) {
                $builder->where('mobile', $account);
            } else {
                $builder->where('account', $account);
            }
            if (isset($plat_form)) {
                $builder->where('password', md5(md5($password) . $salt));
            } else {
                $builder->where('password', md5($password . $salt));
            }

            $model = $builder->first();
        }
        return $model;
    }


    /**
     * @param int $id
     * @return mixed|void
     */
    public function delete($id)
    {
        $builder = FqUserModel::query();
        $builder->whereIn('id', (array)$id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @param $role_id
     * @param $role_type
     * @return array
     */
    public function getFqUserByRoleId($role_id, $role_type)
    {
        $fq_user_entity = [];
        $fq_user_status_arr = FqUserStatus::acceptableEnums();
        $builder = FqUserModel::query();
        $builder->where('role_type', $role_type);
        $builder->where('role_id', $role_id);
        $model = $builder->first();
        if (isset($model)) {
            $fq_user_entity['account_status'] = $fq_user_status_arr[$model->status];
            $fq_user_entity['expire'] = $model->expire;
            $fq_user_entity['account'] = $model->nickname;
        }
        return $fq_user_entity;
    }

    /**
     * @param $role_type
     * @param $company_name
     * @return int
     */
    public function saveCompanyByRoleType($role_type, $company_name)
    {
        switch (intval($role_type)) {
            case FqUserRoleType::PROVIDER :
                $provider_model = new ProviderModel();
                $provider_model->company_name = $company_name;
                $provider_model->save();
                $increment_id = $provider_model->id;
                break;
            case FqUserRoleType::DEVELOPER :
                $developer_model = new DeveloperModel();
                $developer_model->name = $company_name;
                $developer_model->save();
                $increment_id = $developer_model->id;
                break;
            default :
                $increment_id = 0;
                break;
        }

        return $increment_id;
    }

    /**
     * 修改密码
     * @param $fq_user_entity
     */
    public function updatePassword($fq_user_entity)
    {
        /** @var FqUserModel $model */
        $model = FqUserModel::find($fq_user_entity->id);
        if (isset($model)) {
            $model->salt = $model->generateSalt();
            $model->password = $model->getMd5PasswordAndSalt($fq_user_entity->password, $model->salt);
            $model->save();
        }
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return FqUserEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = FqUserModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param FqUserModel $model
     * @return FqUserEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new FqUserEntity();
        $entity->id = $model->id;
        $entity->nickname = $model->nickname;
        $entity->mobile = $model->mobile;
        $entity->email = $model->email;
        $entity->account = $model->account;
        $entity->account_type = $model->account_type;
        $entity->role_type = $model->role_type;
        $entity->role_id = $model->role_id;
        $entity->platform_id = $model->platform_id;
        $entity->register_type_id = $model->register_type_id;
        $entity->avatar = $model->avatar;
        $entity->password = $model->password;
        $entity->project_area = $model->project_area;
        $entity->project_category = $model->project_category;
        $entity->admin_id = $model->admin_id;
        $entity->reg_time = $model->reg_time;
        $entity->expire = $model->expire;
        $entity->status = $model->status;
        $entity->salt = $model->salt;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param $user_id
     * @param $type
     */
    public function updateRoleType($user_id, $type)
    {
        /** @var FqUserEntity $entity */
        $entity = $this->fetch($user_id);
        if (isset($entity)) {
            $entity->role_type = $type;
            $this->save($entity);
        }
    }
}
