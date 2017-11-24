<?php

namespace App\Mobi\Src\Forms\Account;

use App\Mobi\Src\Forms\Form;
use App\Service\FqUser\CheckTokenService;
use App\Src\Exception\LoginException;
use App\Src\FqUser\Domain\Model\CheckThirdPartyEntity;
use Illuminate\Support\MessageBag;


class CheckThirdPartyForm extends Form
{
    public $check_third_party_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'third_type' => 'required|integer',
            'open_id'    => 'required|string',
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
            'reg_id'     => '推送设备ID',
        ];
    }

    public function validation()
    {
        $this->check_third_party_specification = new CheckThirdPartyEntity();
        $this->check_third_party_specification->third_type = array_get($this->data, 'third_type');
        $this->check_third_party_specification->open_id = trim(array_get($this->data, 'open_id'));
        $reg_id = trim(array_get($this->data, 'reg_id'));
        if (empty($reg_id) && strcasecmp(trim(CheckTokenService::getDeviceType()), "android") == 0) {
            throw new LoginException(":reg_id必填", LoginException::ERROR_MISS_PARAM);
        }
        $this->check_third_party_specification->reg_id = $reg_id;

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