<?php namespace App\Admin\Src\Forms\Provider\ProviderServiceNetwork;

use App\Src\Provider\Domain\Model\ProviderServiceNetworkSpecification;
use App\Admin\Src\Forms\Form;

class ProviderServiceNetworkSearchForm extends Form
{

    /**
     * @var ProviderServiceNetworkSpecification
     */
    public $provider_service_network_specification;

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
            'status'      => '服务网点状态',
        ];
    }

    public function validation()
    {
        $this->provider_service_network_specification = new ProviderServiceNetworkSpecification();
        $this->provider_service_network_specification->provider_id = array_get($this->data, 'provider_id');
        $this->provider_service_network_specification->status = array_get($this->data, 'status');
        $this->provider_service_network_specification->keyword = array_get($this->data, 'keyword');
    }
}