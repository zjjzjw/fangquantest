<?php

namespace App\Wap\Src\Forms\Account;

use App\Wap\Src\Forms\Form;
use App\Src\Exception\LoginException;
use App\Src\FqUser\Domain\Model\MobileRegisterEntity;
use Illuminate\Support\MessageBag;


class MobileRegisterForm extends Form
{
    public $mobile_register_specification;

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
            'password'   => 'required|string',
            'reg_id'     => 'nullable|string',
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
            'password'   => '密码',
            'reg_id'     => '密码',
        ];
    }

    public function validation()
    {
        $this->mobile_register_specification = new MobileRegisterEntity();
        $this->mobile_register_specification->phone = trim(array_get($this->data, 'phone'));
        $this->mobile_register_specification->verifycode = trim(array_get($this->data, 'verifycode'));
        $this->mobile_register_specification->password = trim(array_get($this->data, 'password'));
    }

}