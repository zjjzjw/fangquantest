<?php
namespace App\Admin\Src\Forms\Brand\BrandSale;

use App\Src\Brand\Domain\Model\BrandSaleSpecification;
use App\Admin\Src\Forms\Form;

class BrandSaleSearchForm extends Form
{
    /**
     * @var BrandSaleSpecification
     */
    public $brand_sale_specification;

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
        $this->brand_sale_specification = new BrandSaleSpecification();
        $this->brand_sale_specification->keyword = array_get($this->data, 'keyword');
        $this->brand_sale_specification->brand_id = array_get($this->data, 'brand_id');
    }
}