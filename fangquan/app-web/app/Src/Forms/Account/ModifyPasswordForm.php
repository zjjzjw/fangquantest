<?php

namespace App\Web\Src\Forms\Account;

use App\Src\FqUser\Domain\Model\FqUserEntity;
use App\Src\FqUser\Infra\Repository\FqUserRepository;
use App\Src\Role\Domain\Model\UserEntity;
use App\Web\Src\Forms\Form;

class ModifyPasswordForm extends Form
{


    public $password;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password'     => 'required|string',
            'password'         => 'required|string',
            'confirm_password' => 'required|string',
        ];
    }

    protected function messages()
    {
        return [
            'required' => ':attribute必填。',
            'integer'  => ':attribute必须是数字',
            'string'   => ':attribute必须是字符串',
        ];
    }

    public function attributes()
    {
        return [
            'old_password'     => '旧密码',
            'password'         => '新密码',
            'confirm_password' => '确认新密码',
        ];
    }

    public function validation()
    {
        $this->password = array_get($this->data, 'password');
        $old_password = array_get($this->data, 'old_password');
        $confirm_password = array_get($this->data, 'confirm_password');
        $user_id = request()->user()->id;
        $fq_user_repository = new FqUserRepository();
        /** @var FqUserEntity $fq_user_entity */
        $fq_user_entity = $fq_user_repository->fetch($user_id);
        if ($fq_user_entity->password !== md5(md5($old_password) . $fq_user_entity->salt)) {
            $this->addError('old_password', '错误');
        }
        if ($this->password !== $confirm_password) {
            $this->addError('confirm', '两次密码不一致');
        }
    }

}