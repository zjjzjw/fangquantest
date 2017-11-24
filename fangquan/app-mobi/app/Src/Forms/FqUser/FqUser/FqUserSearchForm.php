<?php namespace App\Admin\Src\Forms\FqUser\FqUser;

use App\Src\FqUser\Domain\Model\FqUserSpecification;
use App\Admin\Src\Forms\Form;


class FqUserSearchForm extends Form
{
    /**
     * @var FqUserSpecification
     */
    public $fq_user_specification;

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
        $this->fq_user_specification = new FqUserSpecification();
    }
}