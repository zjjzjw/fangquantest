<?php

namespace App\Admin\Src\Forms\Brand\SaleChannel;


use App\Admin\Src\Forms\Form;
use App\Src\Brand\Domain\Model\SaleChannelEntity;
use App\Src\Brand\Infra\Repository\SaleChannelRepository;

class SaleChannelStoreForm extends Form
{
    /**
     * @var SaleChannelEntity
     */
    public $sale_channel_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'brand_id'     => 'required|integer',
            'channel_type' => 'required|string',
            'sale_year'    => 'required|integer',
            'sale_volume'  => 'required|numeric',

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
            'brand_id'     => '品牌id',
            'channel_type' => '销售渠道',
            'sale_year'    => '年份',
            'sale_volume'  => '销售量',
        ];
    }

    public function validation()
    {
        $sale_channel_repository = new SaleChannelRepository();
        if ($id = array_get($this->data, 'id')) {
            /** @var SaleChannelEntity $sale_channel_entity */
            $sale_channel_entity = $sale_channel_repository->fetch(array_get($this->data, 'id'));
        } else {
            //如果是创建，判断是否已存在
            $sale_channel_repository = new SaleChannelRepository();
            $sale_channel_entity = $sale_channel_repository->getSaleChannelByParams(array_get($this->data, 'brand_id'),
                array_get($this->data, 'sale_year'),
                array_get($this->data, 'channel_type'));
            if (isset($sale_channel_entity)) {
                $this->addError('same_sale', $this->data['sale_year'] . '年数据已存在！');
            }
            $sale_channel_entity = new SaleChannelEntity();
        }
        $sale_channel_entity->brand_id = array_get($this->data, 'brand_id');
        $sale_channel_entity->channel_type = array_get($this->data, 'channel_type');
        $sale_channel_entity->sale_year = array_get($this->data, 'sale_year');
        $sale_channel_entity->sale_volume = array_get($this->data, 'sale_volume');

        $this->sale_channel_entity = $sale_channel_entity;
    }

}