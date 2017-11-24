<?php

namespace App\Admin\Src\Forms\Regional\Province;


use App\Admin\Src\Forms\Form;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Infra\Repository\ProvinceRepository;

class ProvinceStoreForm extends Form
{
    /**
     * @var ProvinceEntity
     */
    public $province_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'      => 'required|integer',
            'name'    => 'required|string',
            'area_id' => 'required|int',
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
            'id'      => '标识',
            'name'    => '省份名称',
            'area_id' => '区域id',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $province_repository = new ProvinceRepository();
            /** @var ProvinceEntity $province_entity */
            $province_entity = $province_repository->fetch(array_get($this->data, 'id'));
        } else {
            $province_entity = new ProvinceEntity();
        }

        $province_entity->name = array_get($this->data, 'name');
        $province_entity->area_id = array_get($this->data, 'area_id');
        $this->province_entity = $province_entity;
    }

}