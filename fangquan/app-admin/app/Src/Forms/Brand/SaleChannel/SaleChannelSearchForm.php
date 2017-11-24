<?php
namespace App\Admin\Src\Forms\Brand\SaleChannel;

use App\Src\Brand\Domain\Model\SaleChannelSpecification;
use App\Admin\Src\Forms\Form;

class SaleChannelSearchForm extends Form
{
    /**
     * @var SaleChannelSpecification
     */
    public $sale_channel_specification;

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
            'brand_id' => '公司标识',
        ];
    }

    public function validation()
    {
        $this->sale_channel_specification = new SaleChannelSpecification();
        $this->sale_channel_specification->keyword = array_get($this->data, 'keyword');
        $this->sale_channel_specification->brand_id = array_get($this->data, 'brand_id');
    }
}