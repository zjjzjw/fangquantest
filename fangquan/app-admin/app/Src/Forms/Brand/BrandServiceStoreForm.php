<?php

namespace App\Admin\Src\Forms\Brand;


use App\Admin\Src\Forms\Form;
use App\Src\Brand\Domain\Model\BrandServiceEntity;
use App\Src\Brand\Infra\Repository\BrandServiceRepository;

class BrandServiceStoreForm extends Form
{
    /**
     * @var BrandServiceEntity
     */
    public $brand_service_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'             => 'required|integer',
            'service_range'  => 'required|string',
            'warranty_range' => 'required|string',
            'supply_cycle'   => 'required|string',
            'file'           => 'nullable|array',
            'service_model'  => 'nullable|array',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误。',
        ];
    }

    public function brands()
    {
        return [
            'id'             => '标识',
            'service_range'  => '服务范围',
            'warranty_range' => '质保期限',
            'supply_cycle'   => '产品供货周期',
        ];
    }

    public function validation()
    {
        $brand_service_repository = new BrandServiceRepository();
        $id = array_get($this->data, 'id');
        /** @var BrandServiceEntity $brand_service_entity */
        $brand_service_entity = $brand_service_repository->getBrandServiceByBrandId($id);
        if (!isset($brand_service_entity)) {
            $brand_service_entity = new BrandServiceEntity();
            $brand_service_entity->brand_id = $id;
        }

        $brand_service_entity->service_range = array_get($this->data, 'service_range');
        $brand_service_entity->warranty_range = array_get($this->data, 'warranty_range');
        $brand_service_entity->supply_cycle = array_get($this->data, 'supply_cycle');
        $brand_service_entity->file = array_get($this->data, 'file');
        $brand_service_entity->service_model = array_get($this->data, 'service_model');


        $this->brand_service_entity = $brand_service_entity;
    }


}