<?php

namespace App\Admin\Src\Forms\Brand\BrandFactory;


use App\Admin\Src\Forms\Form;
use App\Src\Brand\Domain\Model\BrandFactoryEntity;
use App\Src\Brand\Infra\Repository\BrandFactoryRepository;

class BrandFactoryStoreForm extends Form
{
    /**
     * @var BrandFactoryEntity
     */
    public $brand_factory_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'brand_id'        => 'required|integer',
            'factory_type'    => 'nullable|integer',
            'province_id'     => 'nullable|integer',
            'city_id'         => 'nullable|integer',
            'production_area' => 'nullable|numeric',
            'address'         => 'nullable|string',
            'unit'            => 'nullable|string',
            'status'          => 'nullable|integer',
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
            'id'              => '标识',
            'brand_id'        => '品牌id',
            'factory_type'    => '厂家类型',
            'province_id'     => '省份id',
            'city_id'         => '城市id',
            'production_area' => '生产面积',
            'address'         => '地址',
            'unit'            => '面积单位',
            'status'          => '状态',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $brand_factory_repository = new BrandFactoryRepository();
            /** @var BrandFactoryEntity $brand_factory_entity */
            $brand_factory_entity = $brand_factory_repository->fetch(array_get($this->data, 'id'));
        } else {
            $brand_factory_entity = new BrandFactoryEntity();
            $brand_factory_entity->status = 0;
        }

        $brand_factory_entity->brand_id = array_get($this->data, 'brand_id');
        $brand_factory_entity->factory_type = array_get($this->data, 'factory_type');
        $brand_factory_entity->province_id = array_get($this->data, 'province_id');
        $brand_factory_entity->city_id = array_get($this->data, 'city_id');
        $brand_factory_entity->production_area = array_get($this->data, 'production_area');
        $brand_factory_entity->address = array_get($this->data, 'address') ?? '';
        $brand_factory_entity->unit = array_get($this->data, 'unit') ?? '';
        $this->brand_factory_entity = $brand_factory_entity;
    }

}