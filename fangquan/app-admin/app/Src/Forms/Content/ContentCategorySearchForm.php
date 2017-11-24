<?php

namespace App\Admin\Src\Forms\Content;

use App\Src\Content\Domain\Model\ContentCategorySpecification;
use App\Admin\Src\Forms\Form;

class ContentCategorySearchForm extends Form
{

    /**
     * @var ContentCategorySpecification
     */
    public $content_category_specification;

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
        $this->content_category_specification = new ContentCategorySpecification();
        $this->content_category_specification->keyword = array_get($this->data, 'keyword');
    }
}