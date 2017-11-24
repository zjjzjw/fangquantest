<?php

namespace App\Web\Src\Forms\Account;

use App\Src\FqUser\Domain\Model\FqUserEntity;
use App\Src\FqUser\Infra\Repository\FqUserRepository;
use App\Web\Src\Forms\Form;

class ModifyNickNameForm extends Form
{
    /** @var string */
    public $nickname;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nickname' => 'required|string',
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
            'old_password' => '昵称',
        ];
    }

    public function validation()
    {
        $this->nickname = array_get($this->data, 'nickname');
    }

}