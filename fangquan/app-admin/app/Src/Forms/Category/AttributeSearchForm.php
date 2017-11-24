<?php
namespace App\Admin\Src\Forms\Category;

use App\Src\Category\Domain\Model\AttributeSpecification;
use App\Admin\Src\Forms\Form;

class AttributeSearchForm extends Form
{
    /**
     * @var AttributeSpecification
     */
    public $attribute_specification;

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
        $this->attribute_specification = new AttributeSpecification();
        $this->attribute_specification->keyword = array_get($this->data, 'keyword');
        $this->attribute_specification->category_id = array_get($this->data, 'category_id');
        $this->attribute_specification->category_type = array_get($this->data, 'category_type');
    }
}