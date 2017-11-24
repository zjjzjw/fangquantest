<?php

namespace App\Admin\Src\Forms\Brand\BrandSupplementary;


use App\Admin\Src\Forms\Form;
use App\Src\Brand\Domain\Model\BrandSupplementaryEntity;
use App\Src\Brand\Infra\Repository\BrandSupplementaryRepository;

class BrandSupplementaryStoreForm extends Form
{
    /**
     * @var BrandSupplementaryEntity
     */
    public $brand_supplementary_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'desc'                => 'nullable|string',
            'brand_id'            => 'required|integer',
            'supplementary_files' => 'nullable|array',
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
            'id'                  => '标识',
            'desc'                => '描述',
            'brand_id'            => '品牌id',
            'supplementary_files' => '文件',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $brand_supplementary_repository = new BrandSupplementaryRepository();
            /** @var BrandSupplementaryEntity $brand_supplementary_entity */
            $brand_supplementary_entity = $brand_supplementary_repository->fetch(array_get($this->data, 'id'));
        } else {
            $brand_supplementary_entity = new BrandSupplementaryEntity();
        }

        $brand_supplementary_entity->desc = array_get($this->data, 'desc');
        $brand_supplementary_entity->brand_id = array_get($this->data, 'brand_id');
        $brand_supplementary_entity->supplementary_files = array_get($this->data, 'supplementary_files');
        $this->brand_supplementary_entity = $brand_supplementary_entity;
    }

}