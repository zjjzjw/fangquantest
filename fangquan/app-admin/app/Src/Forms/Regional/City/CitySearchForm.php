<?php namespace App\Admin\Src\Forms\Regional\City;

use App\Admin\Src\Forms\Form;
use App\Src\Surport\Domain\Model\CitySpecification;


class CitySearchForm extends Form
{
    /**
     * @var CitySpecification
     */
    public $city_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword'     => 'nullable|string',
            'province_id' => 'nullable|string',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
        ];
    }

    public function attributes()
    {
        return [
            'keyword'     => '关键字',
            'province_id' => '省份ID',
        ];
    }

    public function validation()
    {
        $this->city_specification = new CitySpecification();
        $this->city_specification->keyword = array_get($this->data, 'keyword');
        $this->city_specification->province_id = array_get($this->data, 'province_id');
    }
}