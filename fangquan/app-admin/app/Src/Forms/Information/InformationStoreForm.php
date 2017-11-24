<?php

namespace App\Admin\Src\Forms\Information;


use App\Admin\Src\Forms\Form;
use App\Src\Information\Domain\Model\InformationEntity;
use App\Src\Information\Infra\Repository\InformationRepository;

class InformationStoreForm extends Form
{
    /**
     * @var InformationEntity
     */
    public $information_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                    => 'required|integer',
            'title'                 => 'required|string',
            'thumbnail'             => 'nullable|integer',
            'publish_at'            => 'nullable|string',
            'product_id'            => 'nullable|int',
            'tag_id'                => 'nullable|integer',
            'content'               => 'nullable|string',
            'author'                => 'nullable|string',
            'order'                 => 'nullable|integer',
            'status'                => 'nullable|integer',
            'is_publish'            => 'nullable|integer',
            'brand_ids'             => 'nullable|array',
            'information_categorys' => 'nullable|array',
            'information_themes'    => 'nullable|array',
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
            'id'                    => '标识',
            'title'                 => '标题',
            'order'                 => '排序',
            'status'                => '状态',
            'thumbnail'             => '缩略图',
            'publish_at'            => '发布时间',
            'product_id'            => '产品',
            'author'                => '作者',
            'tag_id'                => '标签',
            'content'               => '内容',
            'brand_ids'             => '品牌',
            'information_categorys' => '品类',
            'information_themes'    => '关键词',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $information_repository = new InformationRepository();
            /** @var InformationEntity $information_entity */
            $information_entity = $information_repository->fetch(array_get($this->data, 'id'));
        } else {
            $information_entity = new InformationEntity();
            $information_entity->created_user_id = request()->user()->id;
            $information_entity->order = 0;
            $information_entity->comment_count = 0;
        }

        $information_brands = array_get($this->data, 'brand_ids');
        $information_entity->title = array_get($this->data, 'title');
        $information_entity->thumbnail = array_get($this->data, 'thumbnail', 0);
        $information_entity->status = array_get($this->data, 'status');
        $information_entity->product_id = array_get($this->data, 'product_id');
        $information_entity->author = array_get($this->data, 'author') ?? '';
        $information_entity->publish_at = array_get($this->data, 'publish_at');
        $information_entity->tag_id = array_get($this->data, 'tag_id');
        $information_entity->content = array_get($this->data, 'content');
        $information_entity->is_publish = array_get($this->data, 'is_publish');
        $information_entity->information_brands = $information_brands ?? [];
        $information_entity->information_categorys = array_get($this->data, 'information_categorys');
        $information_entity->information_themes = array_get($this->data, 'information_themes');
        $this->information_entity = $information_entity;
    }

}