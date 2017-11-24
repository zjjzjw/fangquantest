<?php namespace App\Src\Provider\Infra\Repository;

use App\Foundation\Domain\Repository;

use App\Src\Provider\Domain\Interfaces\ProviderProductFavoriteInterface;
use App\Src\Provider\Domain\Model\ProviderProductFavoriteEntity;
use App\Src\Provider\Infra\Eloquent\ProviderFavoriteModel;
use App\Src\Provider\Infra\Eloquent\ProviderProductFavoriteModel;


class ProviderProductFavoriteRepository extends Repository implements ProviderProductFavoriteInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  ProviderProductFavoriteEntity $provider_product_favorite_entity
     */
    protected function store($provider_product_favorite_entity)
    {
        if ($provider_product_favorite_entity->isStored()) {
            $model = ProviderProductFavoriteModel::find($provider_product_favorite_entity->id);
        } else {
            $model = new ProviderProductFavoriteModel();
        }

        $model->fill(
            [
                'user_id'             => $provider_product_favorite_entity->user_id,
                'provider_product_id' => $provider_product_favorite_entity->provider_product_id,
            ]
        );
        $model->save();
        $provider_product_favorite_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return ProviderProductFavoriteEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProviderProductFavoriteModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProviderProductFavoriteModel $model
     * @return ProviderProductFavoriteEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProviderProductFavoriteEntity();
        $entity->user_id = $model->user_id;
        $entity->provider_product_id = $model->provider_product_id;
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
        $builder = ProviderProductFavoriteModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @param int       $user_id
     * @param int|array $provider_product_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderProductFavoriteByUserIdAndProductId($user_id, $provider_product_id)
    {
        $collect = collect();
        $builder = ProviderProductFavoriteModel::query();
        $builder->where('user_id', $user_id);
        $builder->whereIn('provider_product_id', (array)$provider_product_id);
        $models = $builder->get();
        /** @var ProviderProductFavoriteModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param int|array $user_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderProductFavoriteByUserId($user_id)
    {
        $collect = collect();
        $builder = ProviderProductFavoriteModel::query();
        $builder->whereIn('user_id', (array)$user_id);
        $models = $builder->get();
        /** @var ProviderProductFavoriteModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

}
