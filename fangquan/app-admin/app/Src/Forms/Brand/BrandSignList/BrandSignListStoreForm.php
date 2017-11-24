<?php

namespace App\Admin\Src\Forms\Brand\BrandSignList;


use App\Admin\Src\Forms\Form;
use App\Src\Brand\Domain\Model\BrandSignListEntity;
use App\Src\Brand\Infra\Repository\BrandSignListRepository;

class BrandSignListStoreForm extends Form
{
    /**
     * @var BrandSignListEntity
     */
    public $brand_sign_list_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'brand_id'             => 'required|integer',
            'loupan_id'            => 'required|integer',
            'province_id'          => 'nullable|integer',
            'city_id'              => 'nullable|integer',
            'status'               => 'nullable|integer',
            'product_model'        => 'nullable|string',
            'brand_total_amount'   => 'nullable|numeric',
            'delivery_num'         => 'nullable|string',
            'order_sign_time'      => 'nullable|string',
            'brand_sign_categorys' => 'nullable|array',
            'developer_ids'        => 'nullable|array',
            'developer_names'      => 'nullable|array',
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
            'id'                   => '标识',
            'brand_id'             => '品牌id',
            'loupan_id'            => '楼盘id',
            'province_id'          => '省id',
            'city_id'              => '城市id',
            'status'               => '状态',
            'product_model'        => '产品型号',
            'delivery_num'         => '交付数量',
            'brand_total_amount'   => '交付总金额',
            'order_sign_time'      => '签订时间',
            'developer_ids'        => '开发商',
            'brand_sign_categorys' => '品类',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $brand_sign_list_repository = new BrandSignListRepository();
            /** @var BrandSignListEntity $brand_sign_list_entity */
            $brand_sign_list_entity = $brand_sign_list_repository->fetch(array_get($this->data, 'id'));
        } else {
            $brand_sign_list_entity = new BrandSignListEntity();
            $brand_sign_list_entity->status = 0;
        }

        $brand_sign_list_entity->brand_id = array_get($this->data, 'brand_id');
        $brand_sign_list_entity->loupan_id = array_get($this->data, 'loupan_id');
        $brand_sign_list_entity->province_id = array_get($this->data, 'province_id');
        $brand_sign_list_entity->city_id = array_get($this->data, 'city_id');
        $brand_sign_list_entity->product_model = array_get($this->data, 'product_model');
        $brand_sign_list_entity->delivery_num = array_get($this->data, 'delivery_num') ?? '0';
        $brand_sign_list_entity->brand_total_amount = array_get($this->data, 'brand_total_amount') ?? '';
        $brand_sign_list_entity->order_sign_time = array_get($this->data, 'order_sign_time');
        $brand_sign_list_entity->brand_sign_categorys = array_get($this->data, 'brand_sign_categorys');
        $developers = [];
        $developer_names = array_get($this->data, 'developer_names');
        $developer_ids = array_get($this->data, 'developer_ids');
        if (isset($developer_names) || isset($developer_ids)) {
            foreach ($developer_names as $key => $name) {
                $item['id'] = $developer_ids[$key] ?? 0;
                $item['name'] = $name;
                $developers[] = $item;
            }
        }
        $brand_sign_list_entity->project_developers = $developers;
        $this->brand_sign_list_entity = $brand_sign_list_entity;
    }

}