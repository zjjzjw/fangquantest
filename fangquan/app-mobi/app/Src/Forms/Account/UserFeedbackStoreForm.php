<?php

namespace App\Mobi\Src\Forms\Account;


use App\Mobi\Src\Forms\Form;
use App\Src\Role\Domain\Model\UserFeedbackEntity;
use App\Src\Exception\LoginException;
use Illuminate\Support\MessageBag;

class UserFeedbackStoreForm extends Form
{
    /**
     * @var UserFeedbackEntity
     */
    public $user_feedback_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|string',
            'contact' => 'required|string',
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
            'content' => '内容',
            'contact' => '联系方式',
        ];
    }

    public function validation()
    {
        //user_id
        $user_id = 1;
        $user_feedback_entity = new UserFeedbackEntity();
        $user_feedback_entity->user_id = $user_id;
        $user_feedback_entity->contact = array_get($this->data, 'contact');
        $user_feedback_entity->content = array_get($this->data, 'content');
        $this->user_feedback_entity = $user_feedback_entity;
    }

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