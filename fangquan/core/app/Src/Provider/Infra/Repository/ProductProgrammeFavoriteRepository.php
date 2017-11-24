<?php namespace App\Src\Provider\Infra\Repository;

use App\Foundation\Domain\Repository;

use App\Src\Provider\Domain\Interfaces\ProductProgrammeFavoriteInterface;
use App\Src\Provider\Domain\Model\ProductProgrammeFavoriteEntity;
use App\Src\Provider\Infra\Eloquent\ProductProgrammeFavoriteModel;


class ProductProgrammeFavoriteRepository extends Repository implements ProductProgrammeFavoriteInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  ProductProgrammeFavoriteEntity $product_programme_favorite_entity
     */
    protected function store($product_programme_favorite_entity)
    {
        if ($product_programme_favorite_entity->isStored()) {
            $model = ProductProgrammeFavoriteModel::find($product_programme_favorite_entity->id);
        } else {
            $model = new ProductProgrammeFavoriteModel();
        }

        $model->fill(
            [
                'user_id'              => $product_programme_favorite_entity->user_id,
                'product_programme_id' => $product_programme_favorite_entity->product_programme_id,
            ]
        );
        $model->save();
        $product_programme_favorite_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return ProductProgrammeFavoriteEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProductProgrammeFavoriteModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProductProgrammeFavoriteModel $model
     * @return ProductProgrammeFavoriteEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProductProgrammeFavoriteEntity();
        $entity->user_id = $model->user_id;
        $entity->product_programme_id = $model->product_programme_id;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }


    /**
     * @param int|array $id
     * @return mixed|void
     */
    public function delete($ids)
    {
        $builder = ProductProgrammeFavoriteModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @param int       $user_id
     * @param int|array $product_programme_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProductProgrammeFavoriteByProgrammeIdAndUserId($user_id, $product_programme_id = null)
    {
        $collect = collect();
        $builder = ProductProgrammeFavoriteModel::query();
        $builder->where('user_id', $user_id);
        if (isset($product_programme_id)) {
            $builder->whereIn('product_programme_id', (array)$product_programme_id);
        }
        $models = $builder->get();
        /** @var ProductProgrammeFavoriteModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

}
