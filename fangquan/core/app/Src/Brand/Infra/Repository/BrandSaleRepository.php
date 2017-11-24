<?php namespace App\Src\Brand\Infra\Repository;

use App\Src\Brand\Domain\Model\BrandSaleSpecification;
use App\Foundation\Domain\Repository;
use App\Src\Brand\Domain\Interfaces\BrandSaleInterface;
use App\Src\Brand\Domain\Model\BrandSaleEntity;
use App\Src\Brand\Infra\Eloquent\BrandSaleAreaModel;
use App\Src\Brand\Infra\Eloquent\BrandSaleModel;


class BrandSaleRepository extends Repository implements BrandSaleInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param BrandSaleEntity $brand_sale_entity
     */
    protected function store($brand_sale_entity)
    {
        if ($brand_sale_entity->isStored()) {
            $model = BrandSaleModel::find($brand_sale_entity->id);
        } else {
            $model = new BrandSaleModel();
        }

        $model->fill(
            [
                'name'     => $brand_sale_entity->name,
                'type'     => $brand_sale_entity->type,
                'telphone' => $brand_sale_entity->telphone,
                'status'   => $brand_sale_entity->status,
                'brand_id' => $brand_sale_entity->brand_id,
            ]
        );
        $model->save();
        $this->saveSaleAreas($model, $brand_sale_entity->sale_areas);
        $brand_sale_entity->setIdentity($model->id);
    }

    /**
     * @param BrandSaleModel $model
     * @param                $sale_areas
     */
    protected function saveSaleAreas($model, $sale_areas)
    {
        $item = [];
        $this->deleteSaleAreas($model->id);
        foreach ($sale_areas as $sale_area) {
            $item[] = new BrandSaleAreaModel([
                'area_id' => $sale_area,
            ]);
        }
        $model->sale_areas()->saveMany($item);
    }

    protected function deleteSaleAreas($id)
    {
        $brand_sale_area_query = BrandSaleAreaModel::query();
        $brand_sale_area_query->where('brand_sale_id', $id);
        $brand_sale_area_models = $brand_sale_area_query->get();
        foreach ($brand_sale_area_models as $brand_sale_area_model) {
            $brand_sale_area_model->delete();
        }
    }

    /**
     * @param BrandSaleSpecification $spec
     * @param int                    $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(BrandSaleSpecification $spec, $per_page = 10)
    {
        $builder = BrandSaleModel::query();

        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }

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
     * @return BrandSaleModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = BrandSaleModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param BrandSaleModel $model
     *
     * @return BrandSaleEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new BrandSaleEntity();
        $entity->id = $model->id;

        $entity->name = $model->name;
        $entity->type = $model->type;
        $entity->telphone = $model->telphone;
        $entity->status = $model->status;
        $entity->brand_id = $model->brand_id;
        $entity->sale_areas = $model->sale_areas()->pluck('area_id')->toArray();
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
        $builder = BrandSaleModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $sale_areas = $model->sale_areas()->pluck('id')->toArray();
            if (!empty($sale_areas)) {
                $this->deleteSaleAreas($model->id);
            }
            $model->delete();
        }
    }


    /**
     * @param int $brand_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getBrandSalesByBrandId($brand_id)
    {
        $collect = collect();
        $builder = BrandSaleModel::query();
        $builder->where('brand_id', $brand_id);
        $models = $builder->get();
        /** @var BrandSaleModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;

    }
}