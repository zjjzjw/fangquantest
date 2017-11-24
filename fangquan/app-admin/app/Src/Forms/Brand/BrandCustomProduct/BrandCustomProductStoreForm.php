<?php

namespace App\Admin\Src\Forms\Brand\BrandCustomProduct;


use App\Admin\Src\Forms\Form;
use App\Src\Brand\Domain\Model\BrandCustomProductEntity;
use App\Src\Brand\Infra\Repository\BrandCustomProductRepository;

class BrandCustomProductStoreForm extends Form
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
            'product_name'       => 'required|string',
            'loupan_id'       => 'required|integer',
            'developer_id'   => 'required|string',


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
            'developer_id'     => '开发商标识',
            'loupan_id'     => '楼盘标识',
            'product_name' => '产品名称',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $brand_custom_product_repository = new BrandCustomProductRepository();
            /** @var BrandCustomProductEntity $brand_custom_product_entity */
            $brand_custom_product_entity = $brand_custom_product_repository->fetch(array_get($this->data, 'id'));
        } else {
            $brand_custom_product_entity = new BrandCustomProductEntity();

        }

        $brand_custom_product_entity->brand_id = array_get($this->data, 'brand_id');
        $brand_custom_product_entity->developer_id = array_get($this->data, 'developer_id');
        $brand_custom_product_entity->loupan_id = array_get($this->data, 'loupan_id');
        $brand_custom_product_entity->product_name = array_get($this->data, 'product_name');
        $this->brand_custom_product_entity = $brand_custom_product_entity;
    }

}