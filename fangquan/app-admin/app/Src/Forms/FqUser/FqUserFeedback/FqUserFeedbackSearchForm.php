<?php namespace App\Admin\Src\Forms\FqUser\FqUserFeedback;

use App\Src\FqUser\Domain\Model\FqUserFeedbackSpecification;
use App\Admin\Src\Forms\Form;


class FqUserFeedbackSearchForm extends Form
{
    /**
     * @var FqUserFeedbackSpecification
     */
    public $fq_user_feedback_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword' => 'string',
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
            'keyword' => '关键字',
        ];
    }

    public function validation()
    {
        $this->fq_user_feedback_specification = new FqUserFeedbackSpecification();
    }
}