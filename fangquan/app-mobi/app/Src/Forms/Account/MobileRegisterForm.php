<?php

namespace App\Mobi\Src\Forms\Account;

use App\Mobi\Src\Forms\Form;
use App\Service\FqUser\CheckTokenService;
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
        $reg_id = trim(array_get($this->data, 'reg_id'));
        if (empty($reg_id) && strcasecmp(trim(CheckTokenService::getDeviceType()), "android") == 0) {
            throw new LoginException(":reg_id必填", LoginException::ERROR_MISS_PARAM);
        }
        $this->mobile_register_specification->reg_id = $reg_id;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Support\MessageBag $message
     */
    public function failedValidation(MessageBag $message)
    {
        $msg = '';
        $messages = $this->formatErrors($message);
        if (!empty($messages)) {
            $msg = current(current($messages));
        }
        throw new LoginException(":" . $msg, LoginException::ERROR_MISS_PARAM);
    }
}