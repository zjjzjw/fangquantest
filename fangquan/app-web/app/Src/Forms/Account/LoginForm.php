<?php

namespace App\Web\Src\Forms\Account;

use App\Src\Exception\LoginException;
use App\Src\FqUser\Domain\Model\MobileLoginEntity;
use App\Web\Src\Forms\Form;
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
            'account'  => '账号',
            'password' => '密码',
        ];
    }

    public function validation()
    {
        $this->login_specification = new MobileLoginEntity();
        $this->login_specification->account = array_get($this->data, 'account');
        $this->login_specification->password = array_get($this->data, 'password');
        $this->login_specification->ip = Request::ip();
    }

}