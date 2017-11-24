<?php

namespace App\Wap\Src\Forms\UserInfo;

use App\Admin\Src\Forms\Form;
use App\Src\Content\Domain\Model\UserInfoEntity;
use App\Src\Content\Infra\Repository\UserInfoRepository;

class UserInfoStoreForm extends Form
{
    /**
     * @var UserInfoEntity
     */
    public $user_info_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'       => 'required|integer',
            'name'     => 'required|string',
            'company'  => 'required|string',
            'position' => 'required|string',
            'phone'    => 'required|string',
            'email'    => 'required|email',
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
            'id'       => '标识',
            'name'     => '名字',
            'company'  => '公司',
            'position' => '职位',
            'phone'    => '电话',
            'email'    => '邮件',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $user_info_repository = new UserInfoRepository();
            /** @var UserInfoEntity $user_info_entity */
            $user_info_entity = $user_info_repository->fetch(array_get($this->data, 'id'));
        } else {
            $user_info_entity = new UserInfoEntity();
        }

        $user_info_entity->user_id = request()->user()->id;
        $user_info_entity->name = array_get($this->data, 'name');
        $user_info_entity->company = array_get($this->data, 'company');
        $user_info_entity->position = array_get($this->data, 'position');
        $user_info_entity->phone = array_get($this->data, 'phone');
        $user_info_entity->email = array_get($this->data, 'email');
        $this->user_info_entity = $user_info_entity;
    }
}
