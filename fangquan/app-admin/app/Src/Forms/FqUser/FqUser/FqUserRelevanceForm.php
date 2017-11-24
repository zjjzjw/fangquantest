<?php

namespace App\Admin\Src\Forms\FqUser\FqUser;

use App\Admin\Src\Forms\Form;
use App\Src\FqUser\Domain\Model\FqUserEntity;
use App\Src\FqUser\Infra\Repository\FqUserRepository;


class FqUserRelevanceForm extends Form
{
    /**
     * @var FqUserEntity
     */
    public $fq_user_entity;


    /**
     * Get the validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'id'           => 'required|integer',
            'relevance_id' => 'required|integer',
            'role_type'    => 'required|integer',
        ];
    }

    public function attributes()
    {
        return [
            'id'           => '标识',
            'relevance_id' => '供应商',
            'role_type'    => '类型',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误。',
        ];
    }


    /**
     * validate data by value object;
     * and transform data to valueObject
     */
    protected function validation()
    {
        if (array_get($this->data, 'id')) {
            $fq_user_repository = new FqUserRepository();
            /** @var FqUserEntity $fq_user_entity */
            $fq_user_entity = $fq_user_repository->fetch(array_get($this->data, 'id'));
            $fq_user_entity->role_id = array_get($this->data, 'relevance_id');
            $fq_user_entity->role_type = array_get($this->data, 'role_type');
            $this->fq_user_entity = $fq_user_entity;
        }
    }
}