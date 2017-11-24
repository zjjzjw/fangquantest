<?php

namespace App\Admin\Src\Forms\Content;

use App\Src\Content\Infra\Repository\ContentCategoryRepository;
use App\Src\Content\Domain\Model\ContentCategoryEntity;
use App\Admin\Src\Forms\Form;

/**
 * @property mixed content_category_entity
 */
class ContentCategoryStoreForm extends Form
{
    /** @var ContentCategoryEntity */
    public $content_category_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'   => 'required|string',
            'status' => 'required|integer',

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
            'name'    => '分类名称',
            'status'  => '分类显示状态',
            'keyword' => '关键字',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) { //修改
            $content_category_repository = new ContentCategoryRepository();
            /** @var ContentCategoryEntity $content_category_entity */
            $content_category_entity = $content_category_repository->fetch($id);
        } else {
            $content_category_entity = new ContentCategoryEntity();
            $content_category_entity->parent_id = array_get($this->data, 'parent_id');
        }

        $content_category_entity->name = array_get($this->data, 'name');
        $content_category_entity->status = array_get($this->data, 'status');

        $this->content_category_entity = $content_category_entity;
    }


}