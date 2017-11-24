<?php

namespace App\Mobi\Src\Forms\Provider\ProviderAduitdetails;

use App\Mobi\Src\Forms\Form;
use App\Src\Provider\Domain\Model\ProviderAduitdetailsEntity;
use App\Src\Provider\Infra\Repository\ProviderAduitdetailsRepository;

class  ProviderAduitdetailsStoreForm extends Form
{
    /**
     * @var ProviderAduitdetailsEntity
     */
    public $provider_aduitdetails_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'id'          => 'required|integer',
            'provider_id' => 'required|integer',
            'type'        => 'required|integer',
            'name'        => 'required|string',
            'link'        => 'required|string',
            'filename'    => 'required|string',
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

            'id'          => '标识',
            'provider_id' => '供应商id',
            'type'        => '验厂报告类型',
            'name'        => '文件名',
            'link'        => '链接',
            'filename'    => '文件路径',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $provider_aduitdetails_repository = new ProviderAduitdetailsRepository();
            /** @var ProviderAduitdetailsEntity $provider_aduitdetails_entity */
            $provider_aduitdetails_entity = $provider_aduitdetails_repository->fetch($id);
        } else {
            $provider_aduitdetails_entity = new ProviderAduitdetailsEntity();
            $provider_aduitdetails_entity->desc = array_get($this->data, 'id');
        }

        $provider_aduitdetails_entity->provider_id = array_get($this->data, 'provider_id');
        $provider_aduitdetails_entity->name = array_get($this->data, 'name');
        $provider_aduitdetails_entity->type = array_get($this->data, 'type');
        $provider_aduitdetails_entity->link = array_get($this->data, 'link');
        $provider_aduitdetails_entity->filename = array_get($this->data, 'filename');

        $this->provider_aduitdetails_entity = $provider_aduitdetails_entity;
    }
}