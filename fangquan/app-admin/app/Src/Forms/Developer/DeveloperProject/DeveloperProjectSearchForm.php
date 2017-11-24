<?php

namespace App\Admin\Src\Forms\Developer\DeveloperProject;

use App\Src\Developer\Domain\Model\DeveloperProjectSpecification;
use App\Admin\Src\Forms\Form;

class DeveloperProjectSearchForm extends Form
{
    /**
     * @var DeveloperProjectSpecification
     */
    public $developer_project_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword'      => 'nullable|string',
            'developer_id' => 'nullable|integer',
            'status'       => 'nullable|integer',
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
            'keyword'      => '关键字',
            'developer_id' => '开发商id',
        ];
    }

    public function validation()
    {
        $this->developer_project_specification = new DeveloperProjectSpecification();
        $this->developer_project_specification->keyword = array_get($this->data, 'keyword');
        $this->developer_project_specification->developer_id = array_get($this->data, 'developer_id');
        $this->developer_project_specification->status = array_get($this->data, 'status');
    }
}