<?php

namespace App\Admin\Src\Forms\Role\Role;

use App\Src\Role\Domain\Model\RoleSpecification;
use App\Admin\Src\Forms\Form;

class RoleSearchForm extends Form
{

    /**
     * @var RoleSpecification
     */
    public $role_specification;

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
        $this->role_specification = new RoleSpecification();
        $this->role_specification->keyword = array_get($this->data, 'keyword');
    }
}