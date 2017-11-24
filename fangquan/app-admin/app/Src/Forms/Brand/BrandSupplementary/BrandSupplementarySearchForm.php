<?php

namespace App\Admin\Src\Forms\Brand\BrandSupplementary;

use App\Src\Brand\Domain\Model\BrandSupplementarySpecification;
use App\Admin\Src\Forms\Form;

class BrandSupplementarySearchForm extends Form
{
    /**
     * @var BrandSupplementarySpecification
     */
    public $brand_supplementary_specification;

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
        $this->brand_supplementary_specification = new BrandSupplementarySpecification();
        $this->brand_supplementary_specification->keyword = array_get($this->data, 'keyword');
        $this->brand_supplementary_specification->brand_id = array_get($this->data, 'brand_id');
    }
}