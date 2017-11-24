<?php

namespace App\Web\Src\Forms\Developer;

use App\Src\Developer\Domain\Model\DeveloperStatus;
use App\Web\Src\Forms\Form;
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
        ];
    }

    protected function messages()
    {
        return [
            'required' => ':attribute必填。',
            'integer'  => ':attribute必须整数',
        ];
    }

    public function validation()
    {
        $this->developer_specification = new DeveloperSpecification();
        $this->developer_specification->status = DeveloperStatus::YES;
        $this->developer_specification->keyword = array_get($this->data, 'keyword');
    }
}