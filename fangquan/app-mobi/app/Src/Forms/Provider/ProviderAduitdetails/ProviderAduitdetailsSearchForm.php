<?php

namespace App\Mobi\Src\Forms\Provider\ProviderAduitdetails;

use App\Mobi\Src\Forms\Form;
use App\Src\Provider\Domain\Model\ProviderAduitdetailsSpecification;

class ProviderAduitdetailsSearchForm extends Form
{

    /**
     * @var ProviderAduitdetailsSpecification
     */
    public $provider_aduitdetails_specification;

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
        $this->provider_aduitdetails_specification = new ProviderAduitdetailsSpecification();
        $this->provider_aduitdetails_specification->provider_id = array_get($this->data, 'provider_id');
    }
}