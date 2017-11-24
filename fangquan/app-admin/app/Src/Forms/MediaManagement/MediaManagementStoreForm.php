<?php

namespace App\Admin\Src\Forms\MediaManagement;


use App\Admin\Src\Forms\Form;
use App\Src\MediaManagement\Domain\Model\MediaManagementEntity;
use App\Src\MediaManagement\Domain\Model\MediaManagementType;
use App\Src\MediaManagement\Infra\Repository\MediaManagementRepository;

class MediaManagementStoreForm extends Form
{
    /**
     * @var MediaManagementEntity
     */
    public $media_management_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'     => 'required|integer',
            'name'   => 'required|string',
            'logo'   => 'required|integer',
            'type' => 'required|integer',
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
            'name'   => '媒体名称',
            'logo'   => '封面',
            'type'   => '类型',
        ];
    }

    public function validation()
    {
        $media_management_repository = new MediaManagementRepository();
        if ($id = array_get($this->data, 'id')) {
            /** @var MediaManagementEntity $media_management_entity */
            $media_management_entity = $media_management_repository->fetch(array_get($this->data, 'id'));

        } else {
            $media_management_entity = new MediaManagementEntity();
        }
        $media_management_entity->name = array_get($this->data, 'name');
        $media_management_entity->logo = array_get($this->data, 'logo');
        $media_management_entity->type = array_get($this->data, 'type');
        $this->media_management_entity = $media_management_entity;
    }

}