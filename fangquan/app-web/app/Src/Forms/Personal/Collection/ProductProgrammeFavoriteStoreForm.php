<?php

namespace App\Web\Src\Forms\Personal\Collection;


use App\Admin\Src\Forms\Form;
use App\Src\Provider\Domain\Model\ProductProgrammeFavoriteEntity;
use App\Src\Provider\Infra\Repository\ProductProgrammeFavoriteRepository;

class ProductProgrammeFavoriteStoreForm extends Form
{
    /**
     * @var ProductProgrammeFavoriteEntity
     */
    public $product_programme_favorite_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                   => 'required|integer',
            'product_programme_id' => 'required|integer',
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
            'product_programme_id' => '方案id',
        ];
    }

    public function validation()
    {
        $user_id = request()->user()->id;
        $product_programme_id = array_get($this->data, 'product_programme_id');
        $product_programme_favorite_repository = new ProductProgrammeFavoriteRepository();
        $product_programme_favorite_entity = $product_programme_favorite_repository->getProductProgrammeFavoriteByProgrammeIdAndUserId(
            $user_id, $product_programme_id);

        if ($product_programme_favorite_entity->isEmpty()) {
            $product_programme_favorite_entity = new ProductProgrammeFavoriteEntity();
            $product_programme_favorite_entity->user_id = $user_id;
            $product_programme_favorite_entity->product_programme_id = $product_programme_id;
            $this->product_programme_favorite_entity = $product_programme_favorite_entity;
        } else {
            $this->addError('product_programme_id', '已收藏');
        }
    }

}