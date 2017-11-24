<?php

namespace App\Web\Src\Forms\Personal\Collection;


use App\Admin\Src\Forms\Form;
use App\Src\Developer\Domain\Model\DeveloperProjectFavoriteEntity;
use App\Src\Provider\Domain\Model\ProviderFavoriteEntity;
use App\Src\Provider\Domain\Model\ProviderProductFavoriteEntity;
use App\Src\Provider\Infra\Repository\ProviderFavoriteRepository;
use App\Src\Provider\Infra\Repository\ProviderProductFavoriteRepository;

class ProviderProductFavoriteStoreForm extends Form
{
    /**
     * @var ProviderProductFavoriteEntity
     */
    public $provider_product_favorite_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                  => 'required|integer',
            'provider_product_id' => 'required|integer',
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
            'id'                  => '标识',
            'provider_product_id' => '产品id',
        ];
    }

    public function validation()
    {
        $user_id = request()->user()->id;
        $provider_product_id = array_get($this->data, 'provider_product_id');
        $provider_product_favorite_repository = new ProviderProductFavoriteRepository();
        $provider_product_favorite_entity = $provider_product_favorite_repository->getProviderProductFavoriteByUserIdAndProductId(
            $user_id, $provider_product_id);

        if ($provider_product_favorite_entity->isEmpty()) {
            $provider_product_favorite_entity = new ProviderProductFavoriteEntity();
            $provider_product_favorite_entity->user_id = $user_id;
            $provider_product_favorite_entity->provider_product_id = $provider_product_id;
            $this->provider_product_favorite_entity = $provider_product_favorite_entity;
        } else {
            $this->addError('provider_product_id', '已收藏');
        }
    }

}