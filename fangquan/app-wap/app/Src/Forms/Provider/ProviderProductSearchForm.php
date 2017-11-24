<?php

namespace App\Wap\Src\Forms\Provider;

use App\Src\Provider\Domain\Model\ProviderProductSpecification;
use App\Admin\Src\Forms\Form;

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
            'provider_id' => 'required|integer',
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
            'provider_id' => '供应商标识',
        ];
    }

    public function validation()
    {
        $this->provider_product_specification = new ProviderProductSpecification();
        $this->provider_product_specification->provider_id = array_get($this->data, 'provider_id');
    }
}