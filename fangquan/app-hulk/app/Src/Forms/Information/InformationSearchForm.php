<?php

namespace App\Hulk\Src\Forms\Information;

use App\Src\Information\Domain\Model\InformationSpecification;
use App\Hulk\Src\Forms\Form;

class InformationSearchForm extends Form
{
    /**
     * @var InformationSpecification
     */
    public $information_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword'     => 'nullable|string',
            'tag_id'      => 'nullable|integer',
            'theme_id'    => 'nullable|integer',
            'status'      => 'nullable|integer',
            'category_id' => 'nullable|integer',
            'brand_id'    => 'nullable|integer',
            'product_id'  => 'nullable|integer',
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
            'tag_id'      => '标签ID',
            'theme_id'    => '主题关键字ID',
            'status'      => '状态',
            'category_id' => '品类',
            'brand_id'    => '品牌',
            'product_id'  => '产品',
        ];
    }

    public function validation()
    {
        $this->information_specification = new InformationSpecification();
        $this->information_specification->keyword = array_get($this->data, 'keyword');
        $this->information_specification->tag_id = array_get($this->data, 'tag_id');
        $this->information_specification->theme_id = array_get($this->data, 'theme_id');
        $this->information_specification->page = array_get($this->data, 'page');
        $this->information_specification->status = array_get($this->data, 'status');
        $this->information_specification->category_id = array_get($this->data, 'category_id');
        $this->information_specification->brand_id = array_get($this->data, 'brand_id');
        $this->information_specification->product_id = array_get($this->data, 'product_id');
    }
}