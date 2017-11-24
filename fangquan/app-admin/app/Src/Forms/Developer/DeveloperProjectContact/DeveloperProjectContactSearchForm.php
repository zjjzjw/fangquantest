<?php

namespace App\Admin\Src\Forms\Developer\DeveloperProjectContact;

use App\Src\Developer\Domain\Model\DeveloperProjectContactSpecification;
use App\Admin\Src\Forms\Form;

class DeveloperProjectContactSearchForm extends Form
{
    /**
     * @var DeveloperProjectContactSpecification
     */
    public $developer_project_contact_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword' => 'string',
            'developer_project_id' => 'integer'
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
            'keyword' => '关键字',
            'developer_project_id' => '项目id'
        ];
    }

    public function validation()
    {
        $this->developer_project_contact_specification = new DeveloperProjectContactSpecification();
        $this->developer_project_contact_specification->keyword = array_get($this->data, 'keyword');
        $this->developer_project_contact_specification->developer_project_id = array_get($this->data, 'developer_project_id');
    }
}