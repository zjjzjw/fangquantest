<?php namespace App\Src\Brand\Infra\Repository;

use App\Src\Brand\Domain\Model\BrandCustomProductSpecification;
use App\Foundation\Domain\Repository;
use App\Src\Brand\Domain\Interfaces\BrandCustomProductInterface;
use App\Src\Brand\Domain\Model\BrandCustomProductEntity;
use App\Src\Brand\Infra\Eloquent\BrandCustomProductModel;


class BrandCustomProductRepository extends Repository implements BrandCustomProductInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param BrandCustomProductEntity $brand_sale_entity
     */
    protected function store($brand_custom_product_entity)
    {
        if ($brand_custom_product_entity->isStored()) {
            $model = BrandCustomProductModel::find($brand_custom_product_entity->id);
        } else {
            $model = new BrandCustomProductModel();
        }

        $model->fill(
            [
                'product_name' => $brand_custom_product_entity->product_name,
                'developer_id' => $brand_custom_product_entity->developer_id,
                'loupan_id'    => $brand_custom_product_entity->loupan_id,
                'brand_id'     => $brand_custom_product_entity->brand_id,
            ]
        );
        $model->save();
        $brand_custom_product_entity->setIdentity($model->id);
    }

    /**
     * @paramBrandCustomProductSpecification $spec
     * @param int $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(BrandCustomProductSpecification $spec, $per_page = 10)
    {
        $builder = BrandCustomProductModel::query();


        if ($spec->brand_id) {
            $builder->where('brand_id', $spec->brand_id);
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
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return BrandCustomProductModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = BrandCustomProductModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param BrandCustomProductModel $model
     *
     * @return BrandCustomProductEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new BrandCustomProductEntity();
        $entity->id = $model->id;
        $entity->product_name = $model->product_name;
        $entity->developer_id = $model->developer_id;
        $entity->loupan_id = $model->loupan_id;
        $entity->brand_id = $model->brand_id;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }


    /**
     * @param int|array $ids
     */
    public function delete($ids)
    {
        $builder = BrandCustomProductModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @param $brand_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getBrandCustomProductsByBrandId($brand_id)
    {
        $collect = collect();
        $builder = BrandCustomProductModel::query();
        $builder->where('brand_id', $brand_id);
        $models = $builder->get();
        /** @var BrandCustomProductModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

}