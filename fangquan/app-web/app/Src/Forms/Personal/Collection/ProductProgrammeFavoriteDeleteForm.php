<?php

namespace App\Web\Src\Forms\Personal\Collection;

use App\Admin\Src\Forms\Form;
use App\Src\Provider\Domain\Model\ProductProgrammeFavoriteEntity;
use App\Src\Provider\Infra\Repository\ProductProgrammeFavoriteRepository;

class ProductProgrammeFavoriteDeleteForm extends Form
{


    /**
     * @var int
     */
    public $id;

    public $product_programme_id;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                  => 'required|integer',
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
            'id'                  => '标识',
            'product_programme_id' => '产品id',
        ];
    }

    public function validation()
    {
        $this->id = array_get($this->data, 'id');
        $product_programme_id = array_get($this->data, 'product_programme_id');
        $user_id = request()->user()->id;
        $product_programme_favorite_repository = new ProductProgrammeFavoriteRepository();
        $product_programme_favorite_entities = $product_programme_favorite_repository->getProductProgrammeFavoriteByProgrammeIdAndUserId(
            $user_id, $product_programme_id);
        if (!$product_programme_favorite_entities->isEmpty()) {
            $product_programme_favorite_ids = [];
            /** @var ProductProgrammeFavoriteEntity $product_programme_favorite_entity */
            foreach ($product_programme_favorite_entities as $product_programme_favorite_entity) {
                $product_programme_favorite_ids[] = $product_programme_favorite_entity->id;
            }
            $this->product_programme_id = $product_programme_favorite_ids;
        } else {
            $this->addError('provider_product_id', '操作有误');
        }
    }

}