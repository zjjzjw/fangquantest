<?php

namespace App\Mobi\Src\Forms\Provider\ProviderPropaganda;

use App\Admin\Src\Forms\Form;
use App\Src\Provider\Domain\Model\ProviderPropagandaEntity;
use App\Src\Provider\Domain\Model\ProviderPropagandaStatus;
use App\Src\Provider\Infra\Repository\ProviderPropagandaRepository;

class  ProviderPropagandaStoreForm extends Form
{
    /**
     * @var ProviderPropagandaEntity
     */
    public $provider_propaganda_entity;

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
            'image_id'    => 'required|integer',
            'link'        => 'required|string',
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
            'image_id'    => '图片id',
            'link'        => '链接',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $provider_propaganda_repository = new ProviderPropagandaRepository();
            /** @var ProviderPropagandaEntity $ProviderPropagandaEntity */
            $provider_propaganda_entity = $provider_propaganda_repository->fetch($id);
        } else {
            $provider_propaganda_entity = new ProviderPropagandaEntity();
//            $provider_propaganda_entity->id = array_get($this->data, 'id');

            $provider_propaganda_entity->status = ProviderPropagandaStatus::STATUS_PASS;
        }

        $provider_propaganda_entity->provider_id = array_get($this->data, 'provider_id');
        $provider_propaganda_entity->image_id = array_get($this->data, 'image_id');
        $provider_propaganda_entity->link = array_get($this->data, 'link');


        $this->provider_propaganda_entity = $provider_propaganda_entity;
    }
}