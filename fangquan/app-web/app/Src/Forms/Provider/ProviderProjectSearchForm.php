<?php

namespace App\Web\Src\Forms\Provider;

use App\Src\Provider\Domain\Model\ProviderProjectSpecification;
use App\Web\Src\Forms\Form;

class ProviderProjectSearchForm extends Form
{
    /**
     * @var ProviderProjectSpecification
     */
    public $provider_project_specification;

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
        $this->provider_project_specification = new ProviderProjectSpecification();
        $this->provider_project_specification->provider_id = array_get($this->data, 'provider_id');
    }
}