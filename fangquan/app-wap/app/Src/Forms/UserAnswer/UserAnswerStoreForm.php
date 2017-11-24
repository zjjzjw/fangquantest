<?php

namespace App\Wap\Src\Forms\UserAnswer;

use App\Admin\Src\Forms\Form;
use App\Src\Content\Domain\Model\UserAnswerEntity;
use App\Src\Content\Infra\Repository\UserAnswerRepository;

class UserAnswerStoreForm extends Form
{
    /**
     * @var UserAnswerEntity
     */
    public $user_answer_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'     => 'required|integer',
            'answer' => 'required|array',
            'type'   => 'required|string',
            'num'    => 'required|array',
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
            'id'     => '标识',
            'answer' => '回答',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $user_answer_repository = new UserAnswerRepository();
            /** @var UserAnswerEntity $user_answer_entity */
            $user_answer_entity = $user_answer_repository->fetch(array_get($this->data, 'id'));
        } else {
            $user_answer_entity = new UserAnswerEntity();
        }
        $data = [];
        $answer = array_get($this->data, 'answer') ?? [];
        $num = array_get($this->data, 'num') ?? [];
        $start = 0;
        foreach ($num as $key => $value) {
            $data[$key] = array_slice($answer, $start, $value);
            $start = $value + $start;
        }
        $user_answer_entity->user_id = request()->user()->id;
        $user_answer_entity->answer = json_encode($data);
        $this->user_answer_entity = $user_answer_entity;
    }
}
