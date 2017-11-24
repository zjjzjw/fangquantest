<?php

namespace App\Mobi\Src\Forms\Provider\ProviderFriend;

use App\Mobi\Src\Forms\Form;
use App\Src\Provider\Domain\Model\ProviderFriendEntity;
use App\Src\Provider\Domain\Model\ProviderFriendStatus;
use App\Src\Provider\Infra\Repository\ProviderFriendRepository;

class  ProviderFriendStoreForm extends Form
{
    /**
     * @var ProviderFriendEntity
     */
    public $provider_friend_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'id'          => 'required|integer',
            'provider_id' => 'required|integer',
            'name'        => 'required|string',
            'link'        => 'required|string',
            'logo'        => 'required|integer',
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
            'provider_id' => '供应商id',
            'name'        => '开发商名称',
            'link'        => '跳转到站外地址',
            'logo'        => 'logo',
        ];

    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $provider_friend_repository = new ProviderFriendRepository();
            /** @var $provider_friend_entity $provider_friend_entity */
            $provider_friend_entity = $provider_friend_repository->fetch($id);
        } else {
            $provider_friend_entity = new ProviderFriendEntity();
            $provider_friend_entity->status = ProviderFriendStatus::STATUS_PASS;
        }

        $provider_friend_entity->provider_id = array_get($this->data, 'provider_id');
        $provider_friend_entity->name = array_get($this->data, 'name');
        $provider_friend_entity->logo = array_get($this->data, 'logo');

        $provider_friend_entity->link = array_get($this->data, 'link');

        $this->provider_friend_entity = $provider_friend_entity;
    }
}