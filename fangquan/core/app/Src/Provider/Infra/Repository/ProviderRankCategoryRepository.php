<?php namespace App\Src\Provider\Infra\Repository;


use App\Foundation\Domain\Repository;
use App\Src\Provider\Domain\Interfaces\ProviderRankCategoryInterface;
use App\Src\Provider\Domain\Model\ProviderRankCategoryEntity;
use App\Src\Provider\Domain\Model\ProviderRankCategorySpecification;
use App\Src\Provider\Infra\Eloquent\ProviderRankCategoryModel;

class ProviderRankCategoryRepository extends Repository implements ProviderRankCategoryInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ProviderRankCategoryEntity $provider_rank_category_entity
     */
    protected function store($provider_rank_category_entity)
    {
        if ($provider_rank_category_entity->isStored()) {
            $model = ProviderRankCategoryModel::find($provider_rank_category_entity->id);
        } else {
            $model = new ProviderRankCategoryModel();
        }
        $model->fill(
            [
                'title'       => $provider_rank_category_entity->title,
                'category_id' => $provider_rank_category_entity->category_id,
                'rank'        => $provider_rank_category_entity->rank,
                'provider_id' => $provider_rank_category_entity->provider_id,
            ]
        );
        $model->save();
        $provider_rank_category_entity->setIdentity($model->id);
    }


    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return ProviderRankCategoryEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProviderRankCategoryModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProviderRankCategoryModel $model
     *
     * @return ProviderRankCategoryEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProviderRankCategoryEntity();

        $entity->id = $model->id;
        $entity->title = $model->title;
        $entity->category_id = $model->category_id;
        $entity->rank = $model->rank;
        $entity->provider_id = $model->provider_id;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();

        return $entity;
    }

    /**
     * @param ProviderRankCategorySpecification $spec
     * @param int                               $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ProviderRankCategorySpecification $spec, $per_page = 10)
    {
        $builder = ProviderRankCategoryModel::query();

        if ($spec->provider_id) {
            $builder->where('provider_id', $spec->provider_id);
        }
        if ($spec->category_id) {
            $builder->where('category_id', $spec->category_id);
        }
        if ($spec->keyword) {
            $builder->where('title', 'like', '%' . $spec->keyword . '%');
        }

        $builder->orderBy('created_at', 'asc');

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
     * @param int|array $id
     */
    public function delete($id)
    {
        $builder = ProviderRankCategoryModel::query();
        $builder->whereIn('id', (array)$id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @param $category_id
     * @param $rank
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderRankCategoryByCategoryIdAndRank($category_id, $rank)
    {
        $collect = collect();
        $builder = ProviderRankCategoryModel::query();
        if ($category_id) {
            $builder->where('category_id', $category_id);
        }
        if ($rank) {
            $builder->where('rank', $rank);
        }
        $models = $builder->get();
        /** @var ProviderRankCategoryModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


    /**
     * @param int|array $category_id
     * @param null|int  $limit
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderRankCategoryByCategoryId($category_id, $limit = null)
    {
        $collect = collect();
        $builder = ProviderRankCategoryModel::query();
        if ($category_id) {
            $builder->whereIn('category_id', (array)$category_id);
        }
        if ($limit) {
            $builder->limit($limit);
        }
        $builder->orderBy('rank', 'asc');
        $models = $builder->get();
        /** @var ProviderRankCategoryModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param int $product_category_id
     * @param int $provider_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderRankCategoryByProductCategoryId($product_category_id, $provider_id = null)
    {
        $collect = collect();;
        $builder = ProviderRankCategoryModel::query();
        $builder->where('category_id', $product_category_id);
        if (isset($provider_id)) {
            $builder->where('provider_id', $provider_id);
        }
        $builder->orderby('rank', 'asc');
        $models = $builder->get();
        /** @var ProviderRankCategoryModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model)->stored();
        }
        return $collect;
    }

    /**
     * @param $provider_id
     * @return array
     */
    public function getProviderRankCategoryByProviderId($provider_id)
    {
        $data = [];
        $builder = ProviderRankCategoryModel::query();
        $builder->where('provider_id', $provider_id);
        $models = $builder->get();
        /** @var ProviderRankCategoryModel $model */
        foreach ($models as $model) {
            $data[] = $this->reconstituteFromModel($model)->stored();
        }
        return $data;
    }
}