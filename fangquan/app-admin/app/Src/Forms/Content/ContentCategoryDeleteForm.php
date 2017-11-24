<?php

namespace App\Admin\Src\Forms\Content;

use App\Admin\Src\Forms\Form;
use App\Src\Content\Infra\Repository\ContentCategoryRepository;
use App\Src\Content\Infra\Repository\ContentRepository;

class ContentCategoryDeleteForm extends Form
{


    /**
     * @var int
     */
    public $id;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误。',
        ];
    }

    public function attributes()
    {
        return [
            'id'                     => '标识',
            'content_category'       => '内容分类：',
            'content'                => '内容：',

        ];
    }

    public function validation()
    {
        $this->id = array_get($this->data, 'id');
        $content_category_repository = new ContentCategoryRepository();
        $content_repository = new ContentRepository();
        $content_list=$content_repository->getContentByType($this->id);
        $content_category_list = $content_category_repository->getContentCategoryByParentId($this->id);
        if (!$content_category_list->isEmpty()) {
            $this->addError('content_category', '该分类下有依赖不能删除!');
        }
        if (!$content_list->isEmpty()) {
            $this->addError('content', '该分类下有内容不能删除!');
        }
    }
}