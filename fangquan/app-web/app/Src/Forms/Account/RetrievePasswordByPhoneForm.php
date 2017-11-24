<?php

namespace App\Web\Src\Forms\Account;

use App\Web\Src\Forms\Form;
use App\Src\Exception\LoginException;
use App\Src\FqUser\Domain\Model\RetrievePasswordByPhoneEntity;
use Illuminate\Support\MessageBag;


class RetrievePasswordByPhoneForm extends Form
{
    public $retrieve_password_by_phone_specification;

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
        ];
    }

    public function validation()
    {
        $this->retrieve_password_by_phone_specification = new RetrievePasswordByPhoneEntity();
        $this->retrieve_password_by_phone_specification->phone = trim(array_get($this->data, 'phone'));
        $this->retrieve_password_by_phone_specification->verifycode = trim(array_get($this->data, 'verifycode'));
        $this->retrieve_password_by_phone_specification->password = trim(array_get($this->data, 'password'));
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