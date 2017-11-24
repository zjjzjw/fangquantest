<?php

namespace App\Web\Src\Forms\Provider;

use App\Src\Provider\Domain\Model\ProviderProductProgrammeSpecification;
use App\Web\Src\Forms\Form;

class ProviderProductProgrammeSearchForm extends Form
{

    /**
     * @var ProviderProductProgrammeSpecification
     */
    public $provider_product_programme_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'provider_id' => 'nullable|integer',
            'status'      => 'nullable|integer',
            'keyword'     => 'nullable|string',
            'user_id'     => 'nullable|integer',
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
            'keyword'     => '关键字',
            'provider_id' => '供应商标识',
            'status'      => '状态',
            'user_id'     => '用户id',
        ];
    }

    public function validation()
    {
        $this->provider_product_programme_specification = new ProviderProductProgrammeSpecification();
        $this->provider_product_programme_specification->keyword = array_get($this->data, 'keyword');
        $this->provider_product_programme_specification->provider_id = array_get($this->data, 'provider_id');
        $this->provider_product_programme_specification->status = array_get($this->data, 'status');
        $this->provider_product_programme_specification->user_id = array_get($this->data, 'user_id');
    }
}