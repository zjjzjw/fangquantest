<?php
namespace App\Admin\Src\Forms\Category;

use App\Src\Category\Domain\Model\CategorySpecification;
use App\Admin\Src\Forms\Form;

class CategorySearchForm extends Form
{
    /**
     * @var CategorySpecification
     */
    public $category_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword'   => 'nullable|string',
            'parent_id' => 'nullable|integer',
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
        $this->category_specification = new CategorySpecification();
        $this->category_specification->keyword = array_get($this->data, 'keyword');
        $this->category_specification->parent_id = array_get($this->data, 'parent_id');
    }
}