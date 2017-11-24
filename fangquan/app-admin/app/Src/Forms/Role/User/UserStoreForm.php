<?php

namespace App\Admin\Src\Forms\Role\User;


use App\Admin\Src\Forms\Form;
use App\Src\Role\Domain\Model\UserEntity;
use App\Src\Role\Domain\Model\UserType;
use App\Src\Role\Infra\Repository\UserRepository;

class UserStoreForm extends Form
{
    /**
     * @var UserEntity
     */
    public $user_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'           => 'required|integer',
            'account'      => 'required|string',
            'company_name' => 'required|string',
            'phone'        => 'required|string',
            'name'         => 'required|string',
            'role_ids'     => 'required|array',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误。',
        ];
    }

    public function attributes()
    {
        return [
            'id'           => '标识',
            'account'      => '客户账号',
            'company_name' => '公司名称',
            'position'     => '职位',
            'name'         => '姓名',
            'phone'        => '手机号码',
            'role_ids'     => '角色',
        ];
    }

    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $user_repository = new UserRepository();
            /** @var UserEntity $user_entity */
            $user_entity = $user_repository->fetch(array_get($this->data, 'id'));
        } else {
            $user_entity = new UserEntity();
            $user_entity->employee_id = 0;
            $user_entity->company_id = 0;
            $user_entity->type = 0;
            $user_entity->email = '';
            $user_entity->status = 0;
            $user_entity->created_user_id = request()->user()->id;
        }
        $user_entity->account = array_get($this->data, 'account');
        $user_entity->company_name = array_get($this->data, 'company_name');
        $user_entity->position = array_get($this->data, 'position');
        $user_entity->name = array_get($this->data, 'name');
        $user_entity->phone = array_get($this->data, 'phone');
        $user_entity->role_ids = array_get($this->data, 'role_ids');
        $this->user_entity = $user_entity;
    }

}