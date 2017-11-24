<?php

namespace App\Admin\Src\Forms\Role\Role;

use Carbon\Carbon;
use App\Admin\Src\Forms\Form;
use App\Src\Role\Domain\Model\RoleEntity;
use App\Src\Role\Infra\Repository\RoleRepository;

class  RoleStoreForm extends Form
{
    /**
     * @var RoleEntity
     */
    public $role_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'          => 'required|integer',
            'name'        => 'required|string',
            'user_roles'  => 'array',
            'permissions' => 'required|array',
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
            'id'          => '标识',
            'name'        => '名称',
            'user_roles'  => '员工',
            'permissions' => '权限',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $role_repository = new RoleRepository();
            /** @var RoleEntity $role_entity */
            $role_entity = $role_repository->fetch($id);
        } else {
            $role_entity = new RoleEntity();
            $role_entity->desc = array_get($this->data, 'name');
        }

        $role_entity->name = array_get($this->data, 'name');
        $role_entity->permissions = array_get($this->data, 'permissions');
        $role_entity->users = array_get($this->data, 'user_roles');

        $this->role_entity = $role_entity;
    }
}