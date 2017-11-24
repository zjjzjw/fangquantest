<?php

namespace App\Admin\Src\Forms\Msg\BroadcastMsg;


use App\Admin\Src\Forms\Form;
use App\Src\Msg\Domain\Model\BroadcastMsgEntity;
use App\Src\Msg\Domain\Model\BroadcastMsgStatus;
use App\Src\Msg\Domain\Model\MsgType;
use App\Src\Msg\Infra\Repository\BroadcastMsgRepository;

class BroadcastMsgStoreForm extends Form
{
    /**
     * @var BroadcastMsgEntity
     */
    public $broadcast_msg_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'         => 'required|integer',
            'title'      => 'required|string',
            'msg_images' => 'array',
            'content'    => 'required|string',
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
            'id'         => '标识',
            'title'      => '标题',
            'msg_images' => '图片',
            'content'    => '内容',
        ];
    }

    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $user_msg_repository = new BroadcastMsgRepository();
            /** @var BroadcastMsgEntity $broadcast_msg_entity */
            $broadcast_msg_entity = $user_msg_repository->fetch(array_get($this->data, 'id'));
        } else {
            $broadcast_msg_entity = new BroadcastMsgEntity();
            $broadcast_msg_entity->from_uid = request()->user()->id;
            $broadcast_msg_entity->status = BroadcastMsgStatus::NOT_DEAL;
            $broadcast_msg_entity->msg_type = MsgType::SYSTEM;
        }

        $content = [
            'title' => array_get($this->data, 'title'),
            'images' => array_get($this->data, 'msg_images'),
            'content' => array_get($this->data, 'content')
        ];
        $broadcast_msg_entity->msg_id = array_get($this->data, 'msg_id', 0);
        $broadcast_msg_entity->content = json_encode($content);
        $this->broadcast_msg_entity = $broadcast_msg_entity;
    }

}