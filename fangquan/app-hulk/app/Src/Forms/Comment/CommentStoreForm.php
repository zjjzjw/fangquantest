<?php

namespace App\Hulk\Src\Forms\Comment;


use App\Hulk\Service\Comment\CommentApiService;
use App\Hulk\Src\Forms\Form;
use App\Src\Brand\Infra\Repository\CommentRepository;
use App\Src\Brand\Domain\Model\CommentEntity;

class CommentStoreForm extends Form
{
    /**
     * @var CommentEntity
     */
    public $comment_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'    => 'required|integer',
            'user_id' => 'required|integer',
            'p_id'    => 'required|integer',
            'content' => 'required|string',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填',
            'date_format' => ':attribute格式错误',
        ];
    }

    public function attributes()
    {
        return [
            'id'      => '标识',
            'type'    => '类型',
            'user_id' => '用户id',
            'p_id'    => '关联id',
            'content' => '内容',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $comment_repository = new CommentRepository();
            /** @var CommentEntity $comment_entity */
            $comment_entity = $comment_repository->fetch(array_get($this->data, 'id'));
        } else {
            $comment_entity = new CommentEntity();
            $comment_entity->created_user_id = 0;
        }

        $comment_api_service = new CommentApiService();
        $comment_api_service->updateCommentCount(array_get($this->data, 'p_id'), array_get($this->data, 'type'));

        $comment_entity->user_id = array_get($this->data, 'user_id');
        $comment_entity->p_id = array_get($this->data, 'p_id');
        $comment_entity->content = array_get($this->data, 'content');

        if ($comment_entity->content == 'undefined') {
            $this->addError('content', '内容不能为空！');
        }

        $comment_entity->type = array_get($this->data, 'type');
        $this->comment_entity = $comment_entity;
    }

}