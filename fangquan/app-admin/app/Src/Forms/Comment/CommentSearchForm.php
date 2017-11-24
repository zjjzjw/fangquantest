<?php

namespace App\Admin\Src\Forms\Comment;

use App\Src\Brand\Domain\Model\CommentSpecification;
use App\Admin\Src\Forms\Form;

class CommentSearchForm extends Form
{
    /**
     * @var CommentSpecification
     */
    public $comment_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword' => 'string',
            'type'    => 'integer',
            'p_id'    => 'integer',
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
            'type'    => '类型',
            'p_id'    => '类型',
        ];
    }

    public function validation()
    {
        $this->comment_specification = new CommentSpecification();
        $this->comment_specification->keyword = array_get($this->data, 'keyword');
        $this->comment_specification->type = array_get($this->data, 'type');
        $this->comment_specification->p_id = array_get($this->data, 'p_id');
    }
}