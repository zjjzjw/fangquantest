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
            'keyword'      => 'nullable|string',
            'account_type' => 'nullable|string',
            'company_id'   => 'nullable|integer',
            'platform_id'  => 'nullable|integer',
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
            'keyword'      => '关键字',
            'account_type' => '账户类型',
            'company_id'   => '供应商',
            'platform_id'  => '注册类型',
        ];
    }

    public function validation()
    {
        $this->fq_user_specification = new FqUserSpecification();
        $this->fq_user_specification->keyword = array_get($this->data, 'keyword');
        $this->fq_user_specification->account_type = array_get($this->data, 'account_type');
        $this->fq_user_specification->provider_id = array_get($this->data, 'company_id');
        $this->fq_user_specification->platform_id = array_get($this->data, 'platform_id');
    }
}