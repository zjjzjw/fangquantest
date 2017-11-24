<?php

namespace App\Admin\Src\Forms\Content;


use App\Admin\Src\Forms\Form;
use App\Src\Content\Domain\Model\ContentEntity;
use App\Src\Content\Infra\Repository\ContentRepository;

class ContentStoreForm extends Form
{
    /**
     * @var ContentEntity
     */
    public $content_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                => 'required|integer',
            'title'             => 'required|string',
            'author'            => 'nullable|string',
            'content'           => 'nullable|string',
            'remake'            => 'nullable|string',
            'is_timing_publish' => 'required|integer',
            'publish_time'      => 'nullable|string',
            'type'              => 'required|integer',
            'status'            => 'required|integer',
            'audio'             => 'nullable|integer',
            'url'               => 'nullable|string',
            'audio_title'       => 'nullable|string',
            'image'             => 'nullable|array',
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
            'id'                => '标识',
            'title'             => '标题',
            'author'            => '作者',
            'content'           => '内容',
            'remake'            => '备注',
            'is_timing_publish' => '是否定时发送',
            'publish_time'      => '发布时间',
            'type'              => '类型',
            'status'            => '状态',
            'url'               => '链接',
            'audio'             => '视频',
            'image'             => '图片',
            'audio_title'       => '视频标题',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $content_repository = new ContentRepository();
            /** @var ContentEntity $content_entity */
            $content_entity = $content_repository->fetch(array_get($this->data, 'id'));
        } else {
            $content_entity = new ContentEntity();
        }

        $content_entity->title = array_get($this->data, 'title');
        $content_entity->author = array_get($this->data, 'author') ?? '';
        $content_entity->content = array_get($this->data, 'content');
        $content_entity->remake = array_get($this->data, 'remake') ?? '';
        $content_entity->is_timing_publish = array_get($this->data, 'is_timing_publish');
        $content_entity->publish_time = array_get($this->data, 'publish_time');
        $content_entity->type = array_get($this->data, 'type');
        $content_entity->status = array_get($this->data, 'status');
        $content_entity->audio = array_get($this->data, 'audio') ?? 0;
        $content_entity->url = array_get($this->data, 'url') ?? '';
        $content_entity->audio_title = array_get($this->data, 'audio_title') ?? '';
        $content_entity->content_images = array_get($this->data, 'image') ?? [];
        $this->content_entity = $content_entity;
    }

}