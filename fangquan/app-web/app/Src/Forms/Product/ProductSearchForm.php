<?php

namespace App\Web\Src\Forms\Product;

use App\Src\Product\Domain\Model\ProductSpecification;
use App\Admin\Src\Forms\Form;

class ProductSearchForm extends Form
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
            'brand_ids'           => 'nullable|array',
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
            'brand_id'            => '品牌',
            'brand_ids'           => '品牌数组',
            'product_category_id' => '品类',
        ];
    }

    public function validation()
    {
        $this->product_specification = new ProductSpecification();
        $this->product_specification->keyword = array_get($this->data, 'keyword');
        $this->product_specification->brand_id = array_get($this->data, 'brand_id');
        $this->product_specification->brand_ids = array_get($this->data, 'brand_ids');
        $this->product_specification->product_category_id = array_get($this->data, 'product_category_id');
    }
}