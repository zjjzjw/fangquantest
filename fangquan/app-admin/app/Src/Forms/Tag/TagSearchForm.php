<?php
namespace App\Admin\Src\Forms\Tag;

use App\Src\Tag\Domain\Model\TagSpecification;
use App\Admin\Src\Forms\Form;

class TagSearchForm extends Form
{
    /**
     * @var TagSpecification
     */
    public $tag_specification;

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
        $this->tag_specification = new TagSpecification();
        $this->tag_specification->keyword = array_get($this->data, 'keyword');
    }
}