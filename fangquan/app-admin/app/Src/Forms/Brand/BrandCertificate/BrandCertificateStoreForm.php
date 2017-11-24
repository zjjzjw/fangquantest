<?php

namespace App\Admin\Src\Forms\Brand\BrandCertificate;


use App\Admin\Src\Forms\Form;
use App\Src\Brand\Domain\Model\BrandCertificateEntity;
use App\Src\Brand\Infra\Repository\BrandCertificateRepository;

class BrandCertificateStoreForm extends Form
{
    /**
     * @var BrandCertificateEntity
     */
    public $brand_certificate_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'             => 'required|string',
            'brand_id'         => 'required|integer',
            'type'             => 'nullable|integer',
            'certificate_file' => 'nullable|integer',
            'status'           => 'nullable|integer',
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
            'id'               => '标识',
            'name'             => '名称',
            'brand_id'         => '品牌id',
            'type'             => '证书类型',
            'certificate_file' => '附件',
            'status'           => '状态',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $brand_certificate_repository = new BrandCertificateRepository();
            /** @var BrandCertificateEntity $brand_certificate_entity */
            $brand_certificate_entity = $brand_certificate_repository->fetch(array_get($this->data, 'id'));
        } else {
            $brand_certificate_entity = new BrandCertificateEntity();
            $brand_certificate_entity->status = 0;
        }

        $brand_certificate_entity->name = array_get($this->data, 'name');
        $brand_certificate_entity->brand_id = array_get($this->data, 'brand_id');
        $brand_certificate_entity->type = array_get($this->data, 'type');
        $brand_certificate_entity->certificate_file = array_get($this->data, 'certificate_file') ?? 0;
        $this->brand_certificate_entity = $brand_certificate_entity;
    }

}