<?php

namespace App\Admin\Src\Forms\Brand\BrandSale;


use App\Admin\Src\Forms\Form;
use App\Src\Brand\Domain\Model\BrandSaleEntity;
use App\Src\Brand\Infra\Repository\BrandSaleRepository;

class BrandSaleStoreForm extends Form
{
    /**
     * @var BrandSaleEntity
     */
    public $brand_sale_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'brand_id'   => 'required|integer',
            'name'       => 'required|string',
            'type'       => 'nullable|integer',
            'telphone'   => 'nullable|string',
            'status'     => 'nullable|integer',
            'sale_areas' => 'nullable|array',
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
            'id'       => '标识',
            'brand_id' => '品牌id',
            'name'     => '姓名',
            'type'     => '类型',
            'telphone' => '电话',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $brand_sale_repository = new BrandSaleRepository();
            /** @var BrandSaleEntity $brand_sale_entity */
            $brand_sale_entity = $brand_sale_repository->fetch(array_get($this->data, 'id'));
        } else {
            $brand_sale_entity = new BrandSaleEntity();
            $brand_sale_entity->status = 0;
        }

        $brand_sale_entity->brand_id = array_get($this->data, 'brand_id');
        $brand_sale_entity->name = array_get($this->data, 'name');
        $brand_sale_entity->type = array_get($this->data, 'type');
        $brand_sale_entity->telphone = array_get($this->data, 'telphone');
        $brand_sale_entity->sale_areas = array_get($this->data, 'sale_areas') ?? [];
        $this->brand_sale_entity = $brand_sale_entity;
    }

}