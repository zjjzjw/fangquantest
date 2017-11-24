<?php

namespace App\Mobi\Src\Forms\Account;

use App\Mobi\Src\Forms\Form;
use App\Src\Exception\LoginException;
use Illuminate\Support\MessageBag;
use App\Src\FqUser\Domain\Model\VerifyCodeEntity;


class VerifyCodeForm extends Form
{
    public $verify_code_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => 'required|string',
            'type'  => 'required|integer',
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
            'phone' => '手机号',
            'type'  => '类型',
        ];
    }

    public function validation()
    {
        $this->verify_code_specification = new VerifyCodeEntity();
        $this->verify_code_specification->phone = trim(array_get($this->data, 'phone'));
        $this->verify_code_specification->type = trim(array_get($this->data, 'type'));
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