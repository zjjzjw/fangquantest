<?php namespace App\Mobi\Src\Forms\Provider\ProviderProduct;

use App\Src\Provider\Domain\Model\ProviderProductSpecification;
use App\Src\Provider\Domain\Model\ProviderServiceNetworkSpecification;
use App\Mobi\Src\Forms\Form;

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
        $this->provider_product_specification = new ProviderProductSpecification();
        $this->provider_product_specification->keyword = array_get($this->data, 'keyword');
    }
}