<?php namespace App\Admin\Src\Forms\Regional\ChinaArea;

use App\Admin\Src\Forms\Form;
use App\Src\Surport\Domain\Model\ChinaAreaSpecification;


class ChinaAreaSearchForm extends Form
{
    /**
     * @var ChinaAreaSpecification
     */
    public $china_area_specification;

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
        $this->china_area_specification = new ChinaAreaSpecification();
    }
}