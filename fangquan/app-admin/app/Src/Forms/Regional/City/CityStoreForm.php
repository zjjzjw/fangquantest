<?php

namespace App\Admin\Src\Forms\Regional\City;


use App\Admin\Src\Forms\Form;
use App\Src\Surport\Domain\Model\CityEntity;
use App\Src\Surport\Infra\Repository\CityRepository;

class CityStoreForm extends Form
{
    /**
     * @var CityEntity
     */
    public $city_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'          => 'required|integer',
            'name'        => 'required|string',
            'province_id' => 'required|int',
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
            'id'          => '标识',
            'name'        => '城市名称',
            'province_id' => '省份id',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $city_repository = new CityRepository();
            /** @var CityEntity $city_entity */
            $city_entity = $city_repository->fetch(array_get($this->data, 'id'));
        } else {
            $city_entity = new CityEntity();
        }

        $city_entity->name = array_get($this->data, 'name');
        $city_entity->province_id = array_get($this->data, 'province_id');
        $this->city_entity = $city_entity;
    }

}