<?php

namespace App\Admin\Src\Forms\Regional\ChinaArea;


use App\Admin\Src\Forms\Form;
use App\Src\Surport\Domain\Model\ChinaAreaEntity;
use App\Src\Surport\Infra\Repository\ChinaAreaRepository;

class ChinaAreaStoreForm extends Form
{
    /**
     * @var ChinaAreaEntity
     */
    public $china_area_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'   => 'required|integer',
            'name' => 'required|string',
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
            'id'   => '标识',
            'name' => '区域名称',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $china_area_repository = new ChinaAreaRepository();
            /** @var ChinaAreaEntity $china_area_entity */
            $china_area_entity = $china_area_repository->fetch(array_get($this->data, 'id'));
        } else {
            $china_area_entity = new ChinaAreaEntity();
        }

        $china_area_entity->name = array_get($this->data, 'name');
        $this->china_area_entity = $china_area_entity;
    }

}