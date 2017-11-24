<?php

namespace App\Web\Src\Forms\Provider;

use App\Service\Product\ProductCategoryService;
use App\Src\Product\Domain\Model\ProductCategoryStatus;
use App\Src\Provider\Domain\Model\ProviderProductSpecification;
use App\Web\Src\Forms\Form;

class ProviderProductSearchForm extends Form
{
    /**
     * @var ProviderProductSpecification
     */
    public $provider_product_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'provider_id'         => 'nullable|integer',
            'product_category_id' => 'nullable|integer',
            'user_id'             => 'nullable|integer',
            'status'              => 'nullable|integer',
            'second_product_category_id'              => 'nullable|integer',
        ];
    }

    protected function messages()
    {
        return [
            'required' => ':attribute必填。',
            'integer'  => ':attribute必须整数',
        ];
    }

    public function attributes()
    {
        return [
            'provider_id'         => '供应商标识',
            'product_category_id' => '主营产品',
        ];
    }

    public function validation()
    {
        $this->provider_product_specification = new ProviderProductSpecification();
        $this->provider_product_specification->provider_id = array_get($this->data, 'provider_id');
        $this->provider_product_specification->product_category_id = array_get($this->data, 'product_category_id');
        $this->provider_product_specification->second_product_category_id = array_get($this->data, 'second_product_category_id');
        $this->provider_product_specification->user_id = array_get($this->data, 'user_id');
        $this->provider_product_specification->keyword = array_get($this->data, 'keyword');
        $this->provider_product_specification->status = array_get($this->data, 'status');
    }
}