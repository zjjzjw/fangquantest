<?php

namespace App\Mobi\Src\Forms\Account;

use App\Mobi\Src\Forms\Form;
use App\Service\FqUser\CheckTokenService;
use App\Src\Exception\LoginException;
use App\Src\FqUser\Domain\Model\MobileRegisterEntity;
use App\Src\FqUser\Domain\Model\ThirdPartyRegisterEntity;
use Illuminate\Support\MessageBag;


class ThirdPartyRegisterForm extends Form
{
    public $third_party_register_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'third_type' => 'required|string',
            'open_id'    => 'required|string',
            'nickname'   => 'required|string',
            'avatar'     => 'required|string',
            'reg_id'     => 'nullable|string',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
            'integer'     => ':attribute必须是数字',
            'string'      => ':attribute必须是字符串',
        ];
    }

    public function attributes()
    {
        return [
            'third_type' => '第三方类型',
            'open_id'    => '用户唯一标识',
            'nickname'   => '用户昵称',
            'avatar'     => '用户图像',
            'reg_id'     => '推送设备ID',
        ];
    }

    public function validation()
    {
        $this->third_party_register_specification = new ThirdPartyRegisterEntity();
        $this->third_party_register_specification->third_type = trim(array_get($this->data, 'third_type'));
        $this->third_party_register_specification->open_id = trim(array_get($this->data, 'open_id'));
        $this->third_party_register_specification->password = trim(array_get($this->data, 'nickname'));
        $this->third_party_register_specification->avatar = trim(array_get($this->data, 'avatar'));
        $this->third_party_register_specification->device_type = trim(CheckTokenService::getDeviceType());
        $reg_id = trim(array_get($this->data, 'reg_id'));
        if (empty($reg_id) && strcasecmp(trim(CheckTokenService::getDeviceType()), "android") == 0) {
            throw new LoginException(":reg_id必填", LoginException::ERROR_MISS_PARAM);
        }
        $this->third_party_register_specification->reg_id = $reg_id;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Support\MessageBag $message
     */
    public function failedValidation(MessageBag $message)
    {
        $msg = '';
        $messages = $this->formatErrors($message);
        if (!empty($messages)) {
            $msg = current(current($messages));
        }
        throw new LoginException(":" . $msg, LoginException::ERROR_MISS_PARAM);
    }
}