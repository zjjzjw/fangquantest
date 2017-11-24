<?php

namespace App\Web\Src\Forms\FqUser\FqUserFeedback;

use App\Src\FqUser\Domain\Model\FqUserFeedbackEntity;
use App\Src\FqUser\Domain\Model\FqUserFeedbackStatus;
use App\Src\FqUser\Infra\Repository\FqUserFeedbackRepository;
use App\Web\Src\Forms\Form;

class FqUserFeedbackStoreForm extends Form
{

    /** @var  FqUserFeedbackEntity */
    public $fq_user_feedback_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'      => 'required|integer',
            'content' => 'required|string',
            'contact' => 'nullable|string',
        ];
    }

    protected function messages()
    {
        return [
            'required' => ':attribute必填。',
            'integer'  => ':attribute必须整数',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $fq_user_feedback_repository = new FqUserFeedbackRepository();
            $fq_user_feedback_entity = $fq_user_feedback_repository->fetch($id);
        } else {
            $fq_user_feedback_entity = new FqUserFeedbackEntity();
            if (request()->user()) {
                $fq_user_feedback_entity->fq_user_id = request()->user()->id;
            } else {
                $fq_user_feedback_entity->fq_user_id = 0;
            }
            $fq_user_feedback_entity->image_id = 0;
            $fq_user_feedback_entity->appver = '';
            $fq_user_feedback_entity->device = 'web';
            $fq_user_feedback_entity->status = FqUserFeedbackStatus::NOT_HANDLE;
        }

        $fq_user_feedback_entity->contact = array_get($this->data, 'contact') ?? '';
        $fq_user_feedback_entity->content = array_get($this->data, 'content');

        $this->fq_user_feedback_entity = $fq_user_feedback_entity;

    }
}