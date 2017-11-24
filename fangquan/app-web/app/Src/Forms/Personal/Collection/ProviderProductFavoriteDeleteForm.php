<?php

namespace App\Web\Src\Forms\Personal\Collection;

use App\Admin\Src\Forms\Form;
use App\Src\Provider\Domain\Model\ProviderProductFavoriteEntity;
use App\Src\Provider\Infra\Repository\ProviderProductFavoriteRepository;

class ProviderProductFavoriteDeleteForm extends Form
{


    /**
     * @var int
     */
    public $id;

    public $provider_product_id;

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
        $this->id = array_get($this->data, 'id');
        $provider_product_id = array_get($this->data, 'provider_product_id');
        $user_id = request()->user()->id;
        $provider_product_favorite_repository = new ProviderProductFavoriteRepository();
        $provider_product_favorite_entities = $provider_product_favorite_repository->getProviderProductFavoriteByUserIdAndProductId(
            $user_id, $provider_product_id);
        if (!$provider_product_favorite_entities->isEmpty()) {
            $provider_product_favorite_ids = [];
            /** @var ProviderProductFavoriteEntity $provider_product_favorite_entity */
            foreach ($provider_product_favorite_entities as $provider_product_favorite_entity) {
                $provider_product_favorite_ids[] = $provider_product_favorite_entity->id;
            }
            $this->provider_product_id = $provider_product_favorite_ids;
        } else {
            $this->addError('provider_product_id', '操作有误');
        }
    }

}