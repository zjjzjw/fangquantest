<?php namespace App\Src\Brand\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Brand\Domain\Interfaces\BrandServiceInterface;
use App\Src\Brand\Domain\Model\BrandServiceEntity;
use App\Src\Brand\Infra\Eloquent\BrandServiceModel;
use App\Src\Brand\Infra\Eloquent\ServiceModelModel;
use App\Src\Brand\Infra\Eloquent\ServiceChartModel;


class BrandServiceRepository extends Repository implements BrandServiceInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param BrandServiceEntity $brand_service_entity
     */
    protected function store($brand_service_entity)
    {
        if ($brand_service_entity->isStored()) {
            $model = BrandServiceModel::find($brand_service_entity->id);
        } else {
            $model = new BrandServiceModel();
        }
        $model->fill(
            [
                'brand_id'       => $brand_service_entity->brand_id,
                'service_range'  => $brand_service_entity->service_range,
                'warranty_range' => $brand_service_entity->warranty_range,
                'supply_cycle'   => $brand_service_entity->supply_cycle,
            ]
        );
        $model->save();
        if (isset($brand_service_entity->file)) {
            $this->saveServiceChart($model, $brand_service_entity);
        }
        if (isset($brand_service_entity->service_model)) {
            $this->saveServiceModel($model, $brand_service_entity);
        }

        $brand_service_entity->setIdentity($model->id);
    }


    /**
     * @param BrandServiceModel  $model
     * @param BrandServiceEntity $brand_service_entity
     */
    public function saveServiceModel($model, $brand_service_entity)
    {
        $builder = ServiceModelModel::query();
        $builder->where('service_id', $model->id);
        $service_model_models = $builder->get();
        foreach ($service_model_models as $service_model_model) {
            $service_model_model->delete();
        }
        foreach ($brand_service_entity->service_model as $model_type) {
            $service_model_model = new ServiceModelModel();
            $service_model_model->service_id = $model->id;
            $service_model_model->model_type = $model_type;
            $service_model_model->save();
        }
    }

    /**
     * @param BrandServiceModel  $model
     * @param BrandServiceEntity $brand_service_entity
     */
    protected function saveServiceChart($model, $brand_service_entity)
    {
        $builder = ServiceChartModel::query();
        $builder->where('service_id', $model->id);
        $service_chart_models = $builder->get();
        foreach ($service_chart_models as $service_chart_model) {
            $service_chart_model->delete();
        }
        foreach ($brand_service_entity->file as $image_id) {
            $service_chart_model = new ServiceChartModel();
            $service_chart_model->service_id = $model->id;
            $service_chart_model->image_id = $image_id;
            $service_chart_model->save();
        }
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return BrandServiceModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = BrandServiceModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param BrandServiceModel $model
     *
     * @return BrandServiceEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new BrandServiceEntity();
        $entity->id = $model->id;
        $entity->brand_id = $model->brand_id;
        $entity->service_range = $model->service_range;
        $entity->warranty_range = $model->warranty_range;
        $entity->supply_cycle = $model->supply_cycle;
        $entity->file = $model->service_charts->pluck('image_id')->toArray();
        $entity->service_model = $model->service_models->pluck('model_type')->toArray();
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();

        return $entity;
    }

    /**
     * @param $brand_id
     * @return BrandServiceEntity|null
     */
    public function getBrandServiceByBrandId($brand_id)
    {
        $builder = BrandServiceModel::query();
        $builder->where('brand_id', $brand_id);
        $model = $builder->first();
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }


}