<?php
namespace App\Admin\Src\Forms\Brand\BrandCustomProduct;

use App\Src\Brand\Domain\Model\BrandCustomProductSpecification;
use App\Admin\Src\Forms\Form;

class BrandCustomProductSearchForm extends Form
{
    /**
     * @var BrandCustomProductSpecification
     */
    public $brand_custom_product_specification;

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
        $this->brand_custom_product_specification = new BrandCustomProductSpecification();
        $this->brand_custom_product_specification->keyword = array_get($this->data, 'keyword');
        $this->brand_custom_product_specification->brand_id = array_get($this->data, 'brand_id');
    }
}