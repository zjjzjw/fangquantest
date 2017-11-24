<?php

namespace App\Admin\Src\Forms\Developer\Developer;

use App\Src\Developer\Domain\Model\DeveloperSpecification;
use App\Admin\Src\Forms\Form;

class DeveloperSearchForm extends Form
{
    /**
     * @var DeveloperSpecification
     */
    public $developer_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword' => 'nullable|string',
            'status'  => 'nullable|int',
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
            'status'  => '状态',
        ];
    }

    public function validation()
    {
        $this->developer_specification = new DeveloperSpecification();
        $this->developer_specification->keyword = array_get($this->data, 'keyword');
        $this->developer_specification->status = array_get($this->data, 'status');
    }
}