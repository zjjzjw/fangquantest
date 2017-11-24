<?php namespace App\Src\Provider\Infra\Repository;


use App\Foundation\Domain\Repository;
use App\Src\Provider\Domain\Interfaces\ProviderMainCategoryInterface;
use App\Src\Provider\Domain\Model\ProviderMainCategoryEntity;
use App\Src\Provider\Domain\Model\ProviderMainCategorySpecification;
use App\Src\Provider\Infra\Eloquent\ProviderMainCategoryModel;

class ProviderMainCategoryRepository extends Repository implements ProviderMainCategoryInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ProviderMainCategoryEntity $provider_main_category_entity
     */
    protected function store($provider_main_category_entity)
    {
        if ($provider_main_category_entity->isStored()) {
            $model = ProviderMainCategoryModel::find($provider_main_category_entity->id);
        } else {
            $model = new ProviderMainCategoryModel();
        }
        $model->fill(
            [
                'provider_id'         => $provider_main_category_entity->provider_id,
                'product_category_id' => $provider_main_category_entity->product_category_id,
            ]
        );
        $model->save();
        $provider_main_category_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return ProviderMainCategoryEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProviderMainCategoryModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProviderMainCategoryModel $model
     *
     * @return ProviderMainCategoryEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProviderMainCategoryEntity();

        $entity->id = $model->id;
        $entity->provider_id = $model->provider_id;
        $entity->product_category_id = $model->product_category_id;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();

        return $entity;
    }

    /**
     * @param ProviderMainCategorySpecification $spec
     * @param int                               $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ProviderMainCategorySpecification $spec, $per_page = 10)
    {
        $builder = ProviderMainCategoryModel::query();
        if ($spec->column && $spec->sort) {
            $builder->orderBy($spec->column, $spec->sort);
        } else {
            $builder->orderBy('created_at', 'asc');
        }
        if ($spec->page) {
            $paginator = $builder->paginate($per_page, ['*'], 'page', $spec->page);
        } else {
            $paginator = $builder->paginate($per_page);
        }
        foreach ($paginator as $key => $model) {
            $paginator[$key] = $this->reconstituteFromModel($model)->stored();
        }
        return $paginator;
    }

    /**
     * @param int $provider_id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getProviderMainCategoriesByProviderId($provider_id)
    {
        $builder = ProviderMainCategoryModel::query();
        $builder->where('provider_id', $provider_id);
        $product_main_category = $builder->get();
        foreach ($product_main_category as $key => $model) {
            $product_main_category[$key] = $this->reconstituteFromModel($model)->stored();
        }
        return $product_main_category;
    }


    /**
     * @param int $product_category_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderMainCategoryByProductCategoryId($product_category_id)
    {
        $collect = collect();
        $builder = ProviderMainCategoryModel::query();
        $builder->where('product_category_id', $product_category_id);
        $models = $builder->get();
        /** @var ProviderMainCategoryModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model)->stored();
        }
        return $collect;
    }

    /**
     * @param int|array $id
     */
    public function delete($id)
    {
        $builder = ProviderMainCategoryModel::query();
        $builder->whereIn('id', (array)$id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

}