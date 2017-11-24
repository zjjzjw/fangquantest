<?php

namespace App\Admin\Src\Forms\Msg\UserMsg;


use App\Admin\Src\Forms\Form;
use App\Src\FqUser\Infra\Repository\FqUserRepository;
use App\Src\Msg\Domain\Model\MsgStatus;
use App\Src\Msg\Domain\Model\MsgType;
use App\Src\Msg\Domain\Model\UserMsgEntity;
use App\Src\Msg\Infra\Repository\UserMsgRepository;

class UserMsgStoreForm extends Form
{
    /**
     * @var UserMsgEntity
     */
    public $user_msg_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'         => 'required|integer',
            'mobile'     => 'required|integer',
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
            'mobile'     => '接收人手机号',
            'title'      => '标题',
            'msg_images' => '图片',
            'content'    => '内容',
        ];
    }

    public function validation()
    {
        $fq_user_service = new FqUserRepository();
        if (array_get($this->data, 'id')) {
            $user_msg_repository = new UserMsgRepository();
            /** @var UserMsgEntity $user_msg_entity */
            $user_msg_entity = $user_msg_repository->fetch(array_get($this->data, 'id'));
        } else {
            $user_msg_entity = new UserMsgEntity();
            $user_msg_entity->from_uid = request()->user()->id;
            $user_msg_entity->status = MsgStatus::NOT_READ;
            $user_msg_entity->msg_type = MsgType::SYSTEM;
        }

        $mobile = array_get($this->data, 'mobile');
        $fq_user_entity = $fq_user_service->getFqUserByMobile($mobile);
        if (empty($fq_user_entity)) {
            $this->addError('mobile', '不存在');
        } else {
            $content = [
                'title'   => array_get($this->data, 'title'),
                'images'  => array_get($this->data, 'msg_images'),
                'content' => array_get($this->data, 'content'),
            ];
            $user_msg_entity->to_uid = $fq_user_entity->id;
            $user_msg_entity->msg_id = array_get($this->data, 'msg_id', 0);
            $user_msg_entity->content = json_encode($content);
            $this->user_msg_entity = $user_msg_entity;
        }
    }

}