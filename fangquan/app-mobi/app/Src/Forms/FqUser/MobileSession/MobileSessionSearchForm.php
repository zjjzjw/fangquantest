<?php namespace App\Mobi\Src\Forms\FqUser\MobileSession;

use App\Admin\Src\Forms\Form;
use App\Src\FqUser\Domain\Model\MobileSessionSpecification;


class MobileSessionSearchForm extends Form
{
    /**
     * @var MobileSessionSpecification
     */
    public $mobile_session_specification;

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
        $this->mobile_session_specification = new MobileSessionSpecification();
    }
}