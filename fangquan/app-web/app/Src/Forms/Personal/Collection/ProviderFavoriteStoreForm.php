<?php

namespace App\Web\Src\Forms\Personal\Collection;


use App\Admin\Src\Forms\Form;
use App\Src\Developer\Domain\Model\DeveloperProjectFavoriteEntity;
use App\Src\Provider\Domain\Model\ProviderFavoriteEntity;
use App\Src\Provider\Infra\Repository\ProviderFavoriteRepository;

class ProviderFavoriteStoreForm extends Form
{
    /**
     * @var ProviderFavoriteEntity
     */
    public $provider_favorite_entity;

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
        $user_id = request()->user()->id;
        $provider_id = array_get($this->data, 'provider_id');
        $provider_favorite_repository = new ProviderFavoriteRepository();
        $provider_favorite_entity = $provider_favorite_repository->getProviderFavoriteByUserIdAndProviderId(
            $user_id, $provider_id);

        if ($provider_favorite_entity->isEmpty()) {
            $provider_favorite_entity = new ProviderFavoriteEntity();
            $provider_favorite_entity->user_id = $user_id;
            $provider_favorite_entity->provider_id = $provider_id;
            $this->provider_favorite_entity = $provider_favorite_entity;
        } else {
            $this->addError('developer_project_id', '已收藏');
        }
    }

}