<?php

namespace App\Web\Src\Forms\Provider;

use App\Src\Provider\Domain\Model\ProviderNewsSpecification;
use App\Web\Src\Forms\Form;

class ProviderNewsSearchForm extends Form
{

    /**
     * @var ProviderNewsSpecification
     */
    public $provider_news_specification;

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
            'keyword'     => '关键词',
            'status'      => '状态',
        ];
    }

    public function validation()
    {
        $this->provider_news_specification = new ProviderNewsSpecification();
        $this->provider_news_specification->provider_id = array_get($this->data, 'provider_id');
        $this->provider_news_specification->status = array_get($this->data, 'status');
        $this->provider_news_specification->keyword = array_get($this->data, 'keyword');
    }
}