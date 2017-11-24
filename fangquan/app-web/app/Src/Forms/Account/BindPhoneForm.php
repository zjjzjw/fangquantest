<?php

namespace App\Web\Src\Forms\Account;

use App\Web\Src\Forms\Form;
use App\Src\FqUser\Domain\Model\BindPhoneEntity;


class BindPhoneForm extends Form
{
    public $bind_phone_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone'      => 'required|string',
            'verifycode' => 'required|string',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
            'integer'     => ':attribute必须是数字',
            'string'      => ':attribute必须是字符串',
        ];
    }

    public function attributes()
    {
        return [
            'phone'      => '手机号',
            'verifycode' => '验证码',
        ];
    }

    public function validation()
    {
        $this->bind_phone_specification = new BindPhoneEntity();
        $this->bind_phone_specification->phone = trim(array_get($this->data, 'phone'));
        $this->bind_phone_specification->verifycode = trim(array_get($this->data, 'verifycode'));
    }


}