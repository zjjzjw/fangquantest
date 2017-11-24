<?php namespace App\Src\Brand\Infra\Repository;

use App\Src\Brand\Domain\Model\BrandCooperationSpecification;
use App\Foundation\Domain\Repository;
use App\Src\Brand\Domain\Interfaces\BrandCooperationInterface;
use App\Src\Brand\Domain\Model\BrandCooperationEntity;
use App\Src\Brand\Infra\Eloquent\BrandCooperationModel;


class BrandCooperationRepository extends Repository implements BrandCooperationInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param BrandCooperationEntity $brand_cooperation_entity
     */
    protected function store($brand_cooperation_entity)
    {
        if ($brand_cooperation_entity->isStored()) {
            $model = BrandCooperationModel::find($brand_cooperation_entity->id);
        } else {
            $model = new BrandCooperationModel();
        }

        $model->fill(
            [
                'brand_id'       => $brand_cooperation_entity->brand_id,
                'developer_name' => $brand_cooperation_entity->developer_name,
                'developer_id'   => $brand_cooperation_entity->developer_id,
                'deadline'       => $brand_cooperation_entity->deadline,
                'status'         => $brand_cooperation_entity->status,
                'is_exclusive'   => $brand_cooperation_entity->is_exclusive,
            ]
        );
        $model->save();
        if (!empty($brand_cooperation_entity->brand_cooperation_categorys)) {
            $model->brand_cooperation_categorys()->sync($brand_cooperation_entity->brand_cooperation_categorys);
        }
        $brand_cooperation_entity->setIdentity($model->id);
    }

    /**
     * @param BrandCooperationSpecification $spec
     * @param int                           $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(BrandCooperationSpecification $spec, $per_page = 10)
    {
        $builder = BrandCooperationModel::query();

        if ($spec->keyword) {
            $builder->leftJoin('developer', function ($join) use ($spec) {
                $join->on('developer.id', '=', 'brand_cooperation.developer_id');
            });
            $builder->where('developer.name', 'like', '%' . $spec->keyword . '%');
        }

        if ($spec->brand_id) {
            $builder->where('brand_id', $spec->brand_id);
        }
        $builder->select('brand_cooperation.*');
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
     * @return BrandCooperationModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = BrandCooperationModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param BrandCooperationModel $model
     *
     * @return BrandCooperationEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new BrandCooperationEntity();
        $entity->id = $model->id;

        $entity->brand_id = $model->brand_id;
        $entity->deadline = $model->deadline;
        $entity->developer_id = $model->developer_id;
        $entity->developer_name = $model->developer_name;
        $entity->is_exclusive = $model->is_exclusive;
        $entity->status = $model->status;
        $entity->brand_cooperation_categorys = $model->brand_cooperation_categorys()->pluck('category_id')->toArray();
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
        $builder = BrandCooperationModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $brand_cooperation_categorys = $model->brand_cooperation_categorys()->pluck('category_id')->toArray();
            if (!empty($brand_cooperation_categorys)) {
                $model->brand_cooperation_categorys()->detach($brand_cooperation_categorys);
            }
            $model->delete();
        }
    }

    /**
     * @param $brand_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getBrandCooperationByBrandId($brand_id)
    {
        $collect = collect();
        $builder = BrandCooperationModel::query();
        $builder->where('brand_id', $brand_id);
        $models = $builder->get();
        /** @var BrandCooperationModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

}