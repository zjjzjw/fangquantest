<?php
namespace App\Admin\Src\Forms\Brand\BrandCooperation;

use App\Src\Brand\Domain\Model\BrandCooperationSpecification;
use App\Admin\Src\Forms\Form;

class BrandCooperationSearchForm extends Form
{
    /**
     * @var BrandCooperationSpecification
     */
    public $brand_cooperation_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword' => 'nullable|string',
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
        $this->brand_cooperation_specification = new BrandCooperationSpecification();
        $this->brand_cooperation_specification->keyword = array_get($this->data, 'keyword');
        $this->brand_cooperation_specification->brand_id = array_get($this->data, 'brand_id');
    }
}