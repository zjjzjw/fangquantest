<?php

namespace App\Hulk\Src\Forms\Login;

use App\Service\FqUser\CheckTokenService;
use App\Src\Exception\LoginException;
use App\Src\FqUser\Domain\Model\MobileLoginEntity;
use App\Hulk\Src\Forms\Form;
use App\Src\FqUser\Domain\Model\MobileLoginSpecification;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\MessageBag;

class LoginForm extends Form
{

    /**
     * @var MobileLoginSpecification
     */
    public $login_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account'  => 'required|string',
            'password' => 'required|string',
            'reg_id'   => 'nullable|string',
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
            'provider_id' => '唯一标识',
            'account'     => '账号',
            'password'    => '密码',
        ];
    }

    public function validation()
    {
        $this->login_specification = new MobileLoginEntity();
        $this->login_specification->account = array_get($this->data, 'account');
        $this->login_specification->password = array_get($this->data, 'password');
        $reg_id = array_get($this->data, 'reg_id');
        if (empty($reg_id) && strcasecmp(trim(CheckTokenService::getDeviceType()), "android") == 0) {
            throw new LoginException(":reg_id必填", LoginException::ERROR_MISS_PARAM);
        }
        $this->login_specification->reg_id = $reg_id;
        $this->login_specification->ip = Request::ip();
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