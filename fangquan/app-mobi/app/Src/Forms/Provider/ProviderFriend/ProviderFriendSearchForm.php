<?php

namespace App\Mobi\Src\Forms\Provider\ProviderFriend;

use App\Src\Provider\Domain\Model\ProviderFriendEntity;
use App\Mobi\Src\Forms\Form;
use App\Src\Provider\Domain\Model\ProviderFriendSpecification;

class ProviderFriendSearchForm extends Form
{

    /**
     * @var ProviderFriendSpecification
     */
    public $provider_friend_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'provider_id' => 'required|integer',
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
            'provider_id' => '供应商标识',
        ];
    }

    public function validation()
    {
        $this->provider_friend_specification = new ProviderFriendSpecification();
        $this->provider_friend_specification->provider_id = array_get($this->data, 'provider_id');
    }
}