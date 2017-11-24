<?php

namespace App\Web\Src\Forms\Personal\Collection;

use App\Admin\Src\Forms\Form;
use App\Src\Provider\Domain\Model\ProviderFavoriteEntity;
use App\Src\Provider\Infra\Repository\ProviderFavoriteRepository;

class ProviderFavoriteDeleteForm extends Form
{


    /**
     * @var int
     */
    public $id;

    public $provider_id;

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
        ];
    }

    public function validation()
    {
        $this->id = array_get($this->data, 'id');
        $provider_id = array_get($this->data, 'provider_id');
        $user_id = request()->user()->id;
        $provider_favorite_repository = new ProviderFavoriteRepository();
        $provider_favorite_entities = $provider_favorite_repository->getProviderFavoriteByUserIdAndProviderId(
            $user_id, $provider_id);
        if (!$provider_favorite_entities->isEmpty()) {
            $provider_favorite_ids = [];
            /** @var ProviderFavoriteEntity $provider_favorite_entity */
            foreach ($provider_favorite_entities as $provider_favorite_entity) {
                $provider_favorite_ids[] = $provider_favorite_entity->id;
            }
            $this->provider_id = $provider_favorite_ids;
        } else {
            $this->addError('developer_project_id', '操作有误');
        }
    }

}