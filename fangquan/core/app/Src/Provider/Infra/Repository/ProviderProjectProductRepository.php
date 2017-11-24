<?php namespace App\Src\Provider\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Provider\Domain\Interfaces\ProviderProjectProductInterface;
use App\Src\Provider\Domain\Model\ProviderProjectProductEntity;
use App\Src\Provider\Infra\Eloquent\ProviderProjectProductModel;

class ProviderProjectProductRepository extends Repository implements ProviderProjectProductInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  ProviderProjectProductEntity $provider_project_product_entity
     */
    protected function store($provider_project_product_entity)
    {
        if ($provider_project_product_entity->isStored()) {
            $model = ProviderProjectProductModel::find($provider_project_product_entity->id);
        } else {
            $model = new ProviderProjectProductModel();
        }
        $model->fill(
            [
                'provider_id'    => $provider_project_product_entity->provider_project_id,
                'name'           => $provider_project_product_entity->name,
                'num'            => $provider_project_product_entity->num,
                'measureunit_id' => $provider_project_product_entity->measureunit_id,
            ]
        );
        $model->save();
        $provider_project_product_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return ProviderProjectProductEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProviderProjectProductModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return ProviderProjectProductEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProviderProjectProductEntity();
        $entity->id = $model->id;
        $entity->provider_project_id = $model->provider_project_id;
        $entity->name = $model->name;
        $entity->num = $model->num;
        $entity->measureunit_id = $model->measureunit_id;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param int $provider_project_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderProjectProductByProviderId($provider_project_id)
    {
        $collect = collect();
        $builder = ProviderProjectProductModel::query();
        $builder->where('provider_project_id', $provider_project_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param int|array $id
     */
    public function delete($id)
    {
        $builder = ProviderProjectProductModel::query();
        $builder->whereIn('id', (array)$id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

}