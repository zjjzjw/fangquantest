<?php

namespace App\Mobi\Src\Forms\Provider\ProviderPropaganda;

use App\Admin\Src\Forms\Form;
use App\Src\Provider\Domain\Model\ProviderPropagandaSpecification;

class ProviderPropagandaSearchForm extends Form
{

    /**
     * @var ProviderPropagandaSpecification
     */
    public $provider_propaganda_specification;

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
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
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
        $this->provider_propaganda_specification = new ProviderPropagandaSpecification();
        $this->provider_propaganda_specification->provider_id = array_get($this->data, 'provider_id');
    }
}