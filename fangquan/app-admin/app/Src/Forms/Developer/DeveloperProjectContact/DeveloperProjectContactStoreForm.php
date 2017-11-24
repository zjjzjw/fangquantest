<?php

namespace App\Admin\Src\Forms\Developer\DeveloperProjectContact;


use App\Admin\Src\Forms\Form;
use App\Src\Developer\Domain\Model\DeveloperProjectContactEntity;
use App\Src\Developer\Infra\Repository\DeveloperProjectContactRepository;

class DeveloperProjectContactStoreForm extends Form
{
    /**
     * @var DeveloperProjectContactEntity
     */
    public $developer_project_contact_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                   => 'required|integer',
            'developer_project_id' => 'required|integer',
            'type'                 => 'required|integer',
            'sort'                 => 'integer',
            'company_name'         => 'required|string',
            'contact_name'         => 'required|string',
            'job'                  => 'string',
            'address'              => 'string',
            'telphone'             => 'string',
            'mobile'               => 'required|string',
            'remark'               => 'string',
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
            'id'                   => '标识',
            'developer_project_id' => '开发商项目id',
            'type'                 => '类型',
            'company_name'         => '公司名称',
            'contact_name'         => '姓名',
            'mobile'               => '手机号',
            'telphone'             => '联系电话',
            'remark'               => '备注',
            'job'                  => '职务',
            'address'              => '地址',
            'sort'                 => '排序',
        ];
    }

    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $developer_project_contact_repository = new DeveloperProjectContactRepository();
            /** @var DeveloperProjectContactEntity $developer_project_contact_entity */
            $developer_project_contact_entity = $developer_project_contact_repository->fetch(array_get($this->data, 'id'));
        } else {
            $developer_project_contact_entity = new DeveloperProjectContactEntity();
        }
        $developer_project_contact_entity->developer_project_id = array_get($this->data, 'developer_project_id');
        $developer_project_contact_entity->type = array_get($this->data, 'type');
        $developer_project_contact_entity->company_name = array_get($this->data, 'company_name');
        $developer_project_contact_entity->contact_name = array_get($this->data, 'contact_name');
        $developer_project_contact_entity->mobile = array_get($this->data, 'mobile');
        $developer_project_contact_entity->telphone = array_get($this->data, 'telphone','');
        $developer_project_contact_entity->remark = array_get($this->data, 'remark','');
        $developer_project_contact_entity->job = array_get($this->data, 'job');
        $developer_project_contact_entity->address = array_get($this->data, 'address');
        $developer_project_contact_entity->sort = array_get($this->data, 'sort');
        $this->developer_project_contact_entity = $developer_project_contact_entity;
    }

}