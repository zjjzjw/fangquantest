<?php

namespace App\Hulk\Src\Forms\Product;

use App\Src\Product\Domain\Model\ProductSpecification;
use App\Hulk\Src\Forms\Form;

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
            'keyword'      => 'nullable|string',
            'tag_id'       => 'nullable|integer',
            'theme_id'     => 'nullable|integer',
            'company_type' => 'nullable|string',
            'product_type' => 'nullable|string',
            'category_id'  => 'nullable|integer',
            'attributes'   => 'nullable|string',
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
            'tag_id'       => '标签ID',
            'theme_id'     => '主题关键字ID',
            'company_type' => '公司类型',
            'category_id'  => '品类',
            'product_type' => '产品类型',
            'attributes'   => '属性',
        ];
    }

    public function validation()
    {
        $this->product_specification = new ProductSpecification();
        $this->product_specification->keyword = array_get($this->data, 'keyword');
        $this->product_specification->product_category_id = array_get($this->data, 'category_id');
        $this->product_specification->company_type = array_get($this->data, 'company_type') ? explode(',', array_get($this->data, 'company_type')) : '';
        $this->product_specification->product_type = array_get($this->data, 'product_type') ? explode(',', array_get($this->data, 'product_type')) : '';
        $this->product_specification->attributes = json_decode(array_get($this->data, 'attributes'), true);
        $this->product_specification->page = array_get($this->data, 'page');
    }
}