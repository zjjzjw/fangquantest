<?php namespace App\Src\Provider\Infra\Repository;

use App\Foundation\Domain\Repository;

use App\Src\Provider\Domain\Interfaces\ProviderFavoriteInterface;
use App\Src\Provider\Domain\Model\ProviderFavoriteEntity;
use App\Src\Provider\Infra\Eloquent\ProviderFavoriteModel;


class ProviderFavoriteRepository extends Repository implements ProviderFavoriteInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  ProviderFavoriteEntity $provider_favorite_entity
     */
    protected function store($provider_favorite_entity)
    {
        if ($provider_favorite_entity->isStored()) {
            $model = ProviderFavoriteModel::find($provider_favorite_entity->id);
        } else {
            $model = new ProviderFavoriteModel();
        }
        $model->fill(
            [
                'user_id'     => $provider_favorite_entity->user_id,
                'provider_id' => $provider_favorite_entity->provider_id,
            ]
        );
        $model->save();
        $provider_favorite_entity->setIdentity($model->id);
    }


    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return ProviderFavoriteEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProviderFavoriteModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProviderFavoriteModel $model
     * @return ProviderFavoriteEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProviderFavoriteEntity();
        $entity->user_id = $model->user_id;
        $entity->provider_id = $model->provider_id;
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
        $builder = ProviderFavoriteModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @param int       $user_id
     * @param int|array $provider_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderFavoriteByUserIdAndProviderId($user_id, $provider_id)
    {
        $collect = collect();
        $builder = ProviderFavoriteModel::query();
        $builder->where('user_id', $user_id);
        $builder->whereIn('provider_id', (array)$provider_id);
        $models = $builder->get();
        /** @var ProviderFavoriteModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param $user_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderFavoriteByUserId($user_id)
    {
        $collect = collect();
        $builder = ProviderFavoriteModel::query();
        $builder->where('user_id', (array)$user_id);
        $models = $builder->get();
        /** @var ProviderFavoriteModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;

    }

}
