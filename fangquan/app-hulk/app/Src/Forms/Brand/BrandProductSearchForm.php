<?php

namespace App\Hulk\Src\Forms\Brand;

use App\Src\Product\Domain\Model\ProductSpecification;
use App\Hulk\Src\Forms\Form;

class BrandProductSearchForm extends Form
{
    /**
     * @var ProductSpecification
     */
    public $product_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword'             => 'nullable|string',
            'brand_id'            => 'nullable|integer',
            'product_category_id' => 'nullable|integer',
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
            'keyword'             => '关键字',
            'brand_id'            => '品牌id',
            'product_category_id' => '品类id',
        ];
    }

    public function validation()
    {
        $this->product_specification = new ProductSpecification();
        $this->product_specification->keyword = array_get($this->data, 'keyword');
        $this->product_specification->brand_id = array_get($this->data, 'brand_id');
        $this->product_specification->product_category_id = array_get($this->data, 'product_category_id');
        $this->product_specification->page = array_get($this->data, 'page');
    }
}