<?php

namespace App\Admin\Src\Forms\Brand;


use App\Admin\Src\Forms\Form;
use App\Src\Brand\Domain\Model\BrandEntity;
use App\Src\Brand\Infra\Repository\BrandRepository;

class BrandFriendStoreForm extends Form
{
    /**
     * @var BrandEntity
     */
    public $brand_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                => 'required|integer',
            'strategic_partner' => 'required|array',
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
            'id'                => '标识',
            'strategic_partner' => '合作商',
        ];
    }

    public function validation()
    {
        $brand_repository = new BrandRepository();
        if ($id = array_get($this->data, 'id')) {
            /** @var BrandEntity $brand_entity */
            $brand_entity = $brand_repository->fetch(array_get($this->data, 'id'));
            $brand_entity->brand_friends = array_get($this->data, 'strategic_partner');
            $this->brand_entity = $brand_entity;
        }
    }

}