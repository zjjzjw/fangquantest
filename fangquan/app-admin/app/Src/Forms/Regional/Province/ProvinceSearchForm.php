<?php namespace App\Admin\Src\Forms\Regional\Province;

use App\Admin\Src\Forms\Form;
use App\Src\Surport\Domain\Model\ProvinceSpecification;


class ProvinceSearchForm extends Form
{
    /**
     * @var ProvinceSpecification
     */
    public $province_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword' => 'string',
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
            'keyword' => '关键字',
        ];
    }

    public function validation()
    {
        $this->province_specification = new ProvinceSpecification();
    }
}