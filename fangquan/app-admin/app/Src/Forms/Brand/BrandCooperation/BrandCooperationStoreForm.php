<?php

namespace App\Admin\Src\Forms\Brand\BrandCooperation;


use App\Admin\Src\Forms\Form;
use App\Src\Brand\Domain\Model\BrandCooperationEntity;
use App\Src\Brand\Infra\Repository\BrandCooperationRepository;

class BrandCooperationStoreForm extends Form
{
    /**
     * @var BrandCooperationEntity
     */
    public $brand_cooperation_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                          => 'required|integer',
            'brand_id'                    => 'required|integer',
            'developer_id'                => 'nullable|integer',
            'developer_name'              => 'nullable|string',
            'deadline'                    => 'nullable|string',
            'is_exclusive'                => 'nullable|integer',
            'status'                      => 'nullable|integer',
            'brand_cooperation_categorys' => 'nullable|array',
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
            'id'                          => '标识',
            'brand_id'                    => '品牌id',
            'developer_id'                => '开发商id',
            'developer_name'              => '开发商名称',
            'deadline'                    => '战略期限',
            'is_exclusive'                => '是否独家',
            'status'                      => '状态',
            'brand_cooperation_categorys' => '品类',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $brand_cooperation_repository = new BrandCooperationRepository();
            /** @var BrandCooperationEntity $brand_cooperation_entity */
            $brand_cooperation_entity = $brand_cooperation_repository->fetch(array_get($this->data, 'id'));
        } else {
            $brand_cooperation_entity = new BrandCooperationEntity();
            $brand_cooperation_entity->status = 0;
        }

        $brand_cooperation_entity->brand_id = array_get($this->data, 'brand_id');
        $brand_cooperation_entity->developer_id = array_get($this->data, 'developer_id') ?? 0;
        $brand_cooperation_entity->developer_name = array_get($this->data, 'developer_name');
        $brand_cooperation_entity->deadline = array_get($this->data, 'deadline');
        $brand_cooperation_entity->is_exclusive = array_get($this->data, 'is_exclusive');
        $brand_cooperation_entity->brand_cooperation_categorys = array_get($this->data, 'brand_cooperation_categorys');
        $this->brand_cooperation_entity = $brand_cooperation_entity;
    }

}