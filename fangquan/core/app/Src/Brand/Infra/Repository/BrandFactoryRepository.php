<?php namespace App\Src\Brand\Infra\Repository;

use App\Src\Brand\Domain\Model\BrandFactorySpecification;
use App\Foundation\Domain\Repository;
use App\Src\Brand\Domain\Interfaces\BrandFactoryInterface;
use App\Src\Brand\Domain\Model\BrandFactoryEntity;
use App\Src\Brand\Infra\Eloquent\BrandFactoryModel;


class BrandFactoryRepository extends Repository implements BrandFactoryInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param BrandFactoryEntity $brand_factory_entity
     */
    protected function store($brand_factory_entity)
    {
        if ($brand_factory_entity->isStored()) {
            $model = BrandFactoryModel::find($brand_factory_entity->id);
        } else {
            $model = new BrandFactoryModel();
        }

        $model->fill(
            [
                'brand_id'        => $brand_factory_entity->brand_id,
                'factory_type'    => $brand_factory_entity->factory_type,
                'province_id'     => $brand_factory_entity->province_id,
                'status'          => $brand_factory_entity->status,
                'unit'            => $brand_factory_entity->unit,
                'city_id'         => $brand_factory_entity->city_id,
                'production_area' => $brand_factory_entity->production_area,
                'address'         => $brand_factory_entity->address,
            ]
        );
        $model->save();
        $brand_factory_entity->setIdentity($model->id);
    }

    /**
     * @param BrandFactorySpecification $spec
     * @param int                       $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(BrandFactorySpecification $spec, $per_page = 10)
    {
        $builder = BrandFactoryModel::query();

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
     * @return BrandFactoryModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = BrandFactoryModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param BrandFactoryModel $model
     *
     * @return BrandFactoryEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new BrandFactoryEntity();
        $entity->id = $model->id;

        $entity->brand_id = $model->brand_id;
        $entity->factory_type = $model->factory_type;
        $entity->province_id = $model->province_id;
        $entity->city_id = $model->city_id;
        $entity->unit = $model->unit;
        $entity->production_area = $model->production_area;
        $entity->address = $model->address;
        $entity->status = $model->status;
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
        $builder = BrandFactoryModel::query();
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
    public function getBrandFactoriesByBrandId($brand_id)
    {
        $collect = collect();
        $builder = BrandFactoryModel::query();
        $builder->where('brand_id', $brand_id);
        $models = $builder->get();
        /** @var BrandFactoryModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }
}