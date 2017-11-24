<?php namespace App\Src\Brand\Infra\Repository;

use App\Src\Brand\Domain\Model\BrandSignListSpecification;
use App\Foundation\Domain\Repository;
use App\Src\Brand\Domain\Interfaces\BrandSignListInterface;
use App\Src\Brand\Domain\Model\BrandSignListEntity;
use App\Src\Brand\Infra\Eloquent\BrandSignDeveloperModel;
use App\Src\Brand\Infra\Eloquent\BrandSignListModel;


class BrandSignListRepository extends Repository implements BrandSignListInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param BrandSignListEntity $brand_sign_list_entity
     */
    protected function store($brand_sign_list_entity)
    {
        if ($brand_sign_list_entity->isStored()) {
            $model = BrandSignListModel::find($brand_sign_list_entity->id);
        } else {
            $model = new BrandSignListModel();
        }

        $model->fill(
            [
                'brand_id'           => $brand_sign_list_entity->brand_id,
                'loupan_id'          => $brand_sign_list_entity->loupan_id,
                'province_id'        => $brand_sign_list_entity->province_id,
                'status'             => $brand_sign_list_entity->status,
                'city_id'            => $brand_sign_list_entity->city_id,
                'product_model'      => $brand_sign_list_entity->product_model,
                'brand_total_amount' => $brand_sign_list_entity->brand_total_amount,
                'delivery_num'       => $brand_sign_list_entity->delivery_num,
                'order_sign_time'    => $brand_sign_list_entity->order_sign_time,
            ]
        );
        $model->save();
        if (!empty($brand_sign_list_entity->brand_sign_categorys)) {
            $model->brand_sign_categorys()->sync($brand_sign_list_entity->brand_sign_categorys);
        }

        if (!empty($brand_sign_list_entity->project_developers)) {
            $this->saveSignDeveloper($brand_sign_list_entity->project_developers, $model);
            //$model->project_developers()->sync($brand_sign_list_entity->project_developers);
        }
        $brand_sign_list_entity->setIdentity($model->id);
    }


    protected function saveSignDeveloper($project_developers, $model)
    {
        $item = [];
        $this->deleteSignDeveloper($model->id);
        foreach ($project_developers as $project_developer) {
            $brand_sign_developer_model = new BrandSignDeveloperModel();
            $brand_sign_developer_model->developer_id = $project_developer['id'];
            $brand_sign_developer_model->developer_name = $project_developer['name'];
            $brand_sign_developer_model->project_sign_id = $model->id;
            $brand_sign_developer_model->save();
        }
    }

    protected function deleteSignDeveloper($id)
    {
        $brand_sign_developer_query = BrandSignDeveloperModel::query();
        $brand_sign_developer_query->where('project_sign_id', $id);
        $brand_sign_developer_models = $brand_sign_developer_query->get();
        foreach ($brand_sign_developer_models as $brand_sign_developer_model) {
            $brand_sign_developer_model->forceDelete();
        }
    }

    /**
     * @param BrandSignListSpecification $spec
     * @param int                        $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(BrandSignListSpecification $spec, $per_page = 10)
    {
        $builder = BrandSignListModel::query();

        if ($spec->keyword) {
            $builder->leftJoin('loupan', function ($join) use ($spec) {
                $join->on('loupan.id', '=', 'brand_sign_list.loupan_id');
            });
            $builder->where('loupan.name', 'like', '%' . $spec->keyword . '%');
        }

        if ($spec->brand_id) {
            $builder->where('brand_sign_list.brand_id', $spec->brand_id);
        }
        $builder->select('brand_sign_list.*');
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
     * @return BrandSignListModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = BrandSignListModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param BrandSignListModel $model
     *
     * @return BrandSignListEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new BrandSignListEntity();
        $entity->id = $model->id;

        $entity->brand_id = $model->brand_id;
        $entity->loupan_id = $model->loupan_id;
        $entity->province_id = $model->province_id;
        $entity->city_id = $model->city_id;
        $entity->product_model = $model->product_model;
        $entity->order_sign_time = $model->order_sign_time;
        $entity->delivery_num = $model->delivery_num;
        $entity->brand_total_amount = $model->brand_total_amount;
        $entity->status = $model->status;
        //$entity->project_developers = $model->project_developers()->pluck('developer_id')->toArray();
        $entity->brand_sign_categorys = $model->brand_sign_categorys()->pluck('category_id')->toArray();
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
        $builder = BrandSignListModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $project_developers = $model->project_developers()->pluck('developer_id')->toArray();
            if (!empty($project_developers)) {
                $model->project_developers()->detach($project_developers);
            }

            $brand_sign_categorys = $model->brand_sign_categorys()->pluck('category_id')->toArray();
            if (!empty($brand_sign_categorys)) {
                $model->brand_sign_categorys()->detach($brand_sign_categorys);
            }
            $model->delete();
        }
    }

    /**
     * @param $brand_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getBrandSignListByBrandId($brand_id)
    {
        $collect = collect();
        $builder = BrandSignListModel::query();
        $builder->where('brand_id', $brand_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


}