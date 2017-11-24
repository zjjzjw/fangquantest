<?php

namespace App\Admin\Src\Forms\Provider\ProviderCertificate;

use App\Admin\Src\Forms\Form;
use App\Src\Provider\Domain\Model\ProviderCertificateEntity;
use App\Src\Provider\Infra\Repository\ProviderCertificateRepository;

class  ProviderCertificateStoreForm extends Form
{
    /**
     * @var ProviderCertificateEntity
     */
    public $provider_certificate_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'          => 'required|integer',
            'provider_id' => 'required|integer',
            'name'        => 'required|string',
            'image_id'    => 'required|integer',
            'type'        => 'required|integer',
            'status'      => 'required|integer',
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
            'id'          => '标识',
            'provider_id' => '供应商ID',
            'name'        => '证书名称',
            'image_id'    => '图片资源ID',
            'type'        => '证书类型',
            'status'      => '状态',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $provider_certificate_repository = new ProviderCertificateRepository();
            /** @var ProviderCertificateEntity $provider_certificate_entity */
            $provider_certificate_entity = $provider_certificate_repository->fetch($id);
        } else {
            $provider_certificate_entity = new ProviderCertificateEntity();
        }

        $provider_certificate_entity->provider_id = array_get($this->data, 'provider_id');
        $provider_certificate_entity->name = array_get($this->data, 'name');
        $provider_certificate_entity->image_id = array_get($this->data, 'image_id');
        $provider_certificate_entity->type = array_get($this->data, 'type');
        $provider_certificate_entity->status = array_get($this->data, 'status');

        $this->provider_certificate_entity = $provider_certificate_entity;
    }
}