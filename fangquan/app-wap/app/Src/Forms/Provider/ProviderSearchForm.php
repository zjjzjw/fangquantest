<?php

namespace App\Wap\Src\Forms\Provider;

use App\Src\Provider\Domain\Model\ProviderSpecification;
use App\Admin\Src\Forms\Form;


class ProviderSearchForm extends Form
{
    /** @var  ProviderSpecification */
    public $provider_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_category_id' => 'integer',
            'user_id'             => 'nullable|integer',
            'keyword'             => 'nullable|string',
            'status'              => 'nullable|integer',
        ];
    }

    public function validation()
    {
        $this->provider_specification = new ProviderSpecification();
        $this->provider_specification->product_category_id = array_get($this->data, 'product_category_id');
        $this->provider_specification->user_id = array_get($this->data, 'user_id');
        $this->provider_specification->keyword = array_get($this->data, 'keyword');
        $this->provider_specification->status = array_get($this->data, 'status');
    }
}




