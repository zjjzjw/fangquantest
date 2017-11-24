<?php

namespace App\Admin\Src\Forms\Loupan;


use App\Admin\Src\Forms\Form;

use App\Src\Loupan\Domain\Model\LoupanEntity;

use App\Src\Loupan\Infra\Repository\LoupanRepository;


class LoupanStoreForm extends Form
{
    /**
     * @var LoupanEntity
     */
    public $loupan_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'            => 'required|integer',
            'name'          => 'required|string',
            'province_id'   => 'required|integer',
            'city_id'       => 'required|integer',
            'developer_ids' => 'nullable|array',
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
            'id'            => '标识',
            'name'          => '楼盘名称',
            'province_id'   => '省份',
            'city_id'       => '城市',
            'developer_ids' => '开发商ID',

        ];
    }

    public function validation()
    {
        $loupan_repository = new LoupanRepository();
        $loupan_entity = $loupan_repository->getLoupanListByName(array_get($this->data, 'name'));
        if ($loupan_entity->isNotEmpty()) {
            if ($loupan_entity[0]->id != array_get($this->data, 'id')) {
                $this->addError('name', '不能重复！');
            }
        }

        if ($id = array_get($this->data, 'id')) {
            /** @var LoupanEntity $developer_entity */
            $loupan_entity = $loupan_repository->fetch(array_get($this->data, 'id'));

        } else {
            $loupan_entity = new LoupanEntity();
        }


        $loupan_entity->name = array_get($this->data, 'name');
        $loupan_entity->province_id = array_get($this->data, 'province_id');
        $loupan_entity->city_id = array_get($this->data, 'city_id');
        $loupan_developer = array_get($this->data, 'developer_ids');
        $loupan_entity->loupan_developers = $loupan_developer ?? [];

        $this->loupan_entity = $loupan_entity;
    }

}