<?php

namespace App\Hulk\Src\Forms\Brand;

use App\Src\Brand\Domain\Model\BrandSpecification;
use App\Hulk\Src\Forms\Form;
use App\Src\Provider\Domain\Model\ProviderSpecification;

class BrandSearchForm extends Form
{
    /**
     * @var ProviderSpecification
     */
    public $brand_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword'      => 'nullable|string',
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
            'company_type' => '公司类型',
            'product_type' => '产品类型',
            'category_id'  => '品类id',
            'attributes'   => '属性',
        ];
    }

    public function validation()
    {
        $this->brand_specification = new ProviderSpecification();
        $this->brand_specification->keyword = array_get($this->data, 'keyword');
        $this->brand_specification->page = array_get($this->data, 'page');
        $this->brand_specification->company_type = array_get($this->data, 'company_type');
        $this->brand_specification->product_type = array_get($this->data, 'product_type');
        $this->brand_specification->category_id = array_get($this->data, 'category_id');
        $this->brand_specification->attributes = json_decode(array_get($this->data, 'attributes'), true);
    }
}