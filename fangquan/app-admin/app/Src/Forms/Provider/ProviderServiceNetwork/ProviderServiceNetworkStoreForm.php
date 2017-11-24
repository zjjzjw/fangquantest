<?php namespace App\Admin\Src\Forms\Provider\ProviderServiceNetwork;

use App\Admin\Src\Forms\Form;
use App\Src\Provider\Domain\Model\ProviderServiceNetworkEntity;
use App\Src\Provider\Infra\Repository\ProviderServiceNetworkRepository;

class  ProviderServiceNetworkStoreForm extends Form
{
    /**
     * @var ProviderServiceNetworkEntity
     */
    public $provider_service_network_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'           => 'required|integer',
            'name'         => 'required|string',
            'provider_id'  => 'required|integer',
            'province_id'  => 'required|integer',
            'city_id'      => 'required|integer',
            'address'      => 'required|string',
            'worker_count' => 'required|integer',
            'contact'      => 'required|string',
            'telphone'     => 'required|string',
            'status'       => 'required|integer',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误。',
        ];
    }

    public function attributes()
    {
        return [
            'id'           => '标识',
            'provider_id'  => '供应商ID',
            'name'         => '证书名称',
            'province_id'  => '省市',
            'city_id'      => '城市',
            'address'      => '详细地址',
            'worker_count' => '总员工数',
            'contact'      => '联系人',
            'telphone'     => '联系电话',
            'status'       => '状态',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $provider_certificate_repository = new ProviderServiceNetworkRepository();
            /** @var ProviderServiceNetworkEntity $provider_service_network_entity */
            $provider_service_network_entity = $provider_certificate_repository->fetch($id);
        } else {
            $provider_service_network_entity = new ProviderServiceNetworkEntity();
        }

        $provider_service_network_entity->provider_id = array_get($this->data, 'provider_id');
        $provider_service_network_entity->name = array_get($this->data, 'name');
        $provider_service_network_entity->province_id = array_get($this->data, 'province_id');
        $provider_service_network_entity->city_id = array_get($this->data, 'city_id');
        $provider_service_network_entity->address = array_get($this->data, 'address');
        $provider_service_network_entity->worker_count = array_get($this->data, 'worker_count');
        $provider_service_network_entity->contact = array_get($this->data, 'contact');
        $provider_service_network_entity->telphone = array_get($this->data, 'telphone');
        $provider_service_network_entity->status = array_get($this->data, 'status');

        $this->provider_service_network_entity = $provider_service_network_entity;
    }
}