<?php

namespace App\Admin\Src\Forms\Project;

use App\Src\Project\Domain\Model\ProjectCategorySpecification;
use App\Admin\Src\Forms\Form;

class ProjectCategorySearchForm extends Form
{

    /**
     * @var ProjectCategorySpecification
     */
    public $product_category_specification;

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
        $this->project_category_specification = new ProjectCategorySpecification();
        $this->project_category_specification->keyword = array_get($this->data, 'keyword');
    }
}