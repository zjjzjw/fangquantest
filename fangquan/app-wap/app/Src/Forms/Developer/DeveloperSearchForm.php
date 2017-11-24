<?php

namespace App\Wap\Src\Forms\Developer;

use App\Wap\Src\Forms\Form;
use App\Src\Developer\Domain\Model\DeveloperSpecification;


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
            'status'  => 'nullable|integer',
            'skip'  => 'nullable|integer',
            'page'  => 'nullable|integer',
        ];
    }

    protected function messages()
    {
        return [
            'nullable' => ':attribute可空',
            'integer'  => ':attribute必须整数',
        ];
    }

    public function validation()
    {
        $this->developer_specification = new DeveloperSpecification();
        $this->developer_specification->keyword = array_get($this->data, 'keyword');
        $this->developer_specification->status = array_get($this->data, 'status');
        $this->developer_specification->skip = array_get($this->data, 'skip');
        $this->developer_specification->page = array_get($this->data, 'page');

    }
}