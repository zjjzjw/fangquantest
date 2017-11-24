<?php
namespace App\Admin\Src\Forms\Brand\BrandFactory;

use App\Src\Brand\Domain\Model\BrandFactorySpecification;
use App\Admin\Src\Forms\Form;

class BrandFactorySearchForm extends Form
{
    /**
     * @var BrandFactorySpecification
     */
    public $brand_factory_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword' => 'nullable|string',
            'brand_id' => 'nullable|integer',
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
            'brand_id' => '品牌标识',
        ];
    }

    public function validation()
    {
        $this->brand_factory_specification = new BrandFactorySpecification();
        $this->brand_factory_specification->keyword = array_get($this->data, 'keyword');
        $this->brand_factory_specification->brand_id = array_get($this->data, 'brand_id');
    }
}