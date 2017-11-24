<?php

namespace App\Admin\Src\Forms\Tag;


use App\Admin\Src\Forms\Form;
use App\Src\Tag\Domain\Model\TagEntity;
use App\Src\Tag\Infra\Repository\TagRepository;

class TagStoreForm extends Form
{
    /**
     * @var TagEntity
     */
    public $tag_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'          => 'required|integer',
            'name'        => 'required|string',
            'order'       => 'required|integer',
            'type'        => 'required|integer',
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
            'id'          => '标识',
            'name'        => '名称',
            'order'       => '排序',
            'type'        => '类别',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $tag_repository = new TagRepository();
            /** @var TagEntity $tag_entity */
            $tag_entity = $tag_repository->fetch(array_get($this->data, 'id'));
        } else {
            $tag_entity = new TagEntity();
            $tag_entity->created_user_id = request()->user()->id;
        }

        $tag_entity->name = array_get($this->data, 'name');
        $tag_entity->order = array_get($this->data, 'order');
        $tag_entity->type = array_get($this->data, 'type');
        $this->tag_entity = $tag_entity;
    }

}