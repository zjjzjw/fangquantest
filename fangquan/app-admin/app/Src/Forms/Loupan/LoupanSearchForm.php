<?php

namespace App\Admin\Src\Forms\Loupan;

use App\Src\Loupan\Domain\Model\LoupanSpecification;
use App\Admin\Src\Forms\Form;

class LoupanSearchForm extends Form
{
    /**
     * @var LoupanSpecification
     */
    public $loupan_specification;

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

        ];
    }

    public function validation()
    {
        $this->loupan_specification = new LoupanSpecification();
        $this->loupan_specification->keyword = array_get($this->data, 'keyword');

    }
}