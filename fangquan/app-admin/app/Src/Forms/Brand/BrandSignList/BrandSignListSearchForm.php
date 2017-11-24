<?php

namespace App\Admin\Src\Forms\Brand\BrandSignList;

use App\Src\Brand\Domain\Model\BrandSignListSpecification;
use App\Admin\Src\Forms\Form;

class BrandSignListSearchForm extends Form
{
    /**
     * @var BrandSignListSpecification
     */
    public $brand_sign_list_specification;

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
        $this->brand_sign_list_specification = new BrandSignListSpecification();
        $this->brand_sign_list_specification->keyword = array_get($this->data, 'keyword');
        $this->brand_sign_list_specification->brand_id = array_get($this->data, 'brand_id');
    }
}