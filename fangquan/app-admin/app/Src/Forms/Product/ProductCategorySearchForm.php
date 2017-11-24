<?php

namespace App\Admin\Src\Forms\Product;

use App\Src\Product\Domain\Model\ProductCategorySpecification;
use App\Admin\Src\Forms\Form;

class ProductCategorySearchForm extends Form
{

    /**
     * @var ProductCategorySpecification
     */
    public $product_category_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword' => 'string',
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
        $this->product_category_specification = new ProductCategorySpecification();
        $this->product_category_specification->keyword = array_get($this->data, 'keyword');
    }
}