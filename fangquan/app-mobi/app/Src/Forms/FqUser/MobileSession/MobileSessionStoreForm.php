<?php

namespace App\Mobi\Src\Forms\FqUser\MobileSession;

use App\Admin\Src\Forms\Form;
use App\Src\FqUser\Domain\Model\MobileSessionEntity;
use App\Src\FqUser\Infra\Repository\MobileSessionRepository;
use App\Src\Provider\Domain\Model\ProviderFriendEntity;
use App\Src\Provider\Domain\Model\ProviderFriendStatus;
use App\Src\Provider\Infra\Repository\ProviderFriendRepository;

class  MobileSessionStoreForm extends Form
{
    /**
     * @var MobileSessionEntity
     */
    public $mobile_session_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'id'            => 'required|integer',
            'user_id'       => 'required|integer',
            'token'         => 'required|string',
            'reg_id'        => 'nullable|string',
            'type'          => 'required|integer',
            'enable_notify' => 'nullable|integer',
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

            'id'            => '标识',
            'user_id'       => '用户id',
            'token'         => '访问接口令牌',
            'reg_id'        => '推送的设备id',
            'type'          => '设备类型',
            'enable_notify' => '是否开启推送通知',
        ];

    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $mobile_session_repository = new MobileSessionRepository();
            /** @var $mobile_session_entity $mobile_session_entity */
            $mobile_session_entity = $mobile_session_repository->fetch($id);
        } else {
            $mobile_session_entity = new MobileSessionEntity();
        }

        $mobile_session_entity->user_id = array_get($this->data, 'user_id');
        $mobile_session_entity->token = array_get($this->data, 'token');
        $mobile_session_entity->reg_id = array_get($this->data, 'reg_id');

        $mobile_session_entity->type = array_get($this->data, 'type');

        $mobile_session_entity->enable_notify = array_get($this->data, 'enable_notify') ?? 2;

        $this->mobile_session_entity = $mobile_session_entity;
    }
}