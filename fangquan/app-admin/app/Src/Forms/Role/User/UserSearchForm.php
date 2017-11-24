<?php

namespace App\Admin\Src\Forms\Role\User;

use App\Src\Role\Domain\Model\UserSpecification;
use App\Admin\Src\Forms\Form;

class UserSearchForm extends Form
{

    /**
     * @var UserSpecification
     */
    public $user_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword'     => 'string',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
        ];
    }

    public function attributes()
    {
        return [
            'keyword'   => '关键字',
        ];
    }

    public function validation()
    {
        $this->user_specification = new UserSpecification();
        $this->user_specification->keyword = array_get($this->data, 'keyword');
    }
}