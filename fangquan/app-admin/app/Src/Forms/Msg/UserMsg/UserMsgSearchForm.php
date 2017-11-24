<?php namespace App\Admin\Src\Forms\Msg\UserMsg;

use App\Admin\Src\Forms\Form;
use App\Src\Msg\Domain\Model\UserMsgSpecification;

class UserMsgSearchForm extends Form
{

    /**
     * @var UserMsgSpecification
     */
    public $user_msg_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword'     => 'nullable|string',
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
            'keyword'     => '关键字',
        ];
    }

    public function validation()
    {
        $this->user_msg_specification = new UserMsgSpecification();
        $this->user_msg_specification->keyword = array_get($this->data, 'keyword');
    }
}