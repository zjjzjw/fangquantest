<?php

namespace App\Admin\Src\Forms\Provider\ProviderCertificate;

use App\Src\Provider\Domain\Model\ProviderCertificateSpecification;
use App\Admin\Src\Forms\Form;

class ProviderCertificateSearchForm extends Form
{

    /**
     * @var ProviderCertificateSpecification
     */
    public $provider_certificate_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'provider_id' => 'nullable|integer',
            'keyword'     => 'nullable|string',
            'status'      => 'nullable|integer',
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
            'keyword'     => '关键字',
            'status'      => '状态',
        ];
    }

    public function validation()
    {
        $this->provider_certificate_specification = new ProviderCertificateSpecification();
        $this->provider_certificate_specification->provider_id = array_get($this->data, 'provider_id');
        $this->provider_certificate_specification->keyword = array_get($this->data, 'keyword');
        $this->provider_certificate_specification->status = array_get($this->data, 'status');
    }
}