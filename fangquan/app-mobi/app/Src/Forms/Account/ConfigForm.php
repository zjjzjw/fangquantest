<?php

namespace App\Mobi\Src\Forms\Account;

use App\Mobi\Src\Forms\Form;
use App\Src\Exception\LoginException;
use App\Src\FqUser\Domain\Model\ConfigEntity;
use Illuminate\Support\MessageBag;
use App\Src\FqUser\Domain\Model\VerifyCodeEntity;


class ConfigForm extends Form
{
    public $config_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id'       => 'required|integer',
            'enable_notify' => 'required|integer',
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
            'user_id'       => '用户ID',
            'enable_notify' => '开启推送通知',
        ];
    }

    public function validation()
    {
        $this->config_specification = new ConfigEntity();
        $this->config_specification->user_id = trim(array_get($this->data, 'user_id'));
        $this->config_specification->enable_notify = trim(array_get($this->data, 'enable_notify'));
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