<?php

namespace App\Service\Role;


use App\Admin\Src\Forms\Form;
use App\Src\Role\Domain\Model\DataType;
use App\Src\Role\Domain\Model\UserDataEntity;
use App\Src\Role\Infra\Eloquent\UserModel;
use App\Src\Role\Infra\Repository\UserDataRepository;
use App\Src\Role\Infra\Repository\UserRepository;

class UserDataService
{
    public function getUserDataDepartIds($user_id)
    {
        $user_data_depart_ids = [];
        $user_data_repository = new UserDataRepository();
        $user_data_entities = $user_data_repository->getUserDataByUserId($user_id);
        /** @var UserDataEntity $user_data_entity */
        foreach ($user_data_entities as $user_data_entity) {
            $user_data_depart_ids[] = $user_data_entity->data_id;
        }
        return $user_data_depart_ids;
    }


    /**
     * @param mixed $form
     */
    public function storeDataDepartIds($form)
    {
        $user_data_repository = new  UserDataRepository();
        $user_data_repository->deleteByUserId($form->id);
        foreach ($form->depart_ids as $depart_id) {
            $user_data_entity = new UserDataEntity();
            $user_data_entity->data_type = DataType::TYPE_DEPART;
            $user_data_entity->user_id = $form->id;
            $user_data_entity->data_id = $depart_id;
            $user_data_repository->save($user_data_entity);
        }
    }

    /**
     * 修改用户密码
     * @param mixed $form
     */
    public function storeUserPwd($form)
    {
        $user_model = UserModel::find($form->id);
        $password = md5(md5($form->password) . config('auth.salt'));
        if (isset($user_model)) {
            $user_model->password = $password;
            $user_model->save();
        }
    }

}

