<?php namespace App\Src\Surport\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Domain\Interfaces\ProvinceInterface;
use App\Src\Surport\Domain\Model\ProvinceSpecification;
use App\Src\Surport\Infra\Eloquent\ProvinceModel;


class ProvinceRepository extends Repository implements ProvinceInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ProvinceEntity $province_entity
     */
    protected function store($province_entity)
    {
        if ($province_entity->isStored()) {
            $model = ProvinceModel::find($province_entity->id);
        } else {
            $model = new ProvinceModel();
        }
        $model->fill(
            [
                'name'    => $province_entity->name,
                'area_id' => $province_entity->area_id,
            ]
        );
        $model->save();
        $province_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return ProvinceEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProvinceModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProvinceSpecification $spec
     * @param int                   $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ProvinceSpecification $spec, $per_page = 10)
    {
        $builder = ProvinceModel::query();

        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
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
     * @param ProvinceModel $model
     *
     * @return ProvinceEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProvinceEntity();
        $entity->id = $model->id;
        $entity->area_id = $model->area_id;
        $entity->name = $model->name;

        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        $collection = collect();
        $builder = ProvinceModel::query();
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }

    /**
     * @param $name
     * @return ProvinceEntity|null
     */
    public function getProvinceByName($name)
    {
        $builder = ProvinceModel::query();
        $builder->where('name', 'like', '%' . $name . '%');
        $model = $builder->first();
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $area_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProvinceByAreaId($area_id)
    {
        $collection = collect();
        $builder = ProvinceModel::query();
        $builder->where('area_id', $area_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }


    /**
     * @param int|array $ids
     */
    public function delete($ids)
    {
        $builder = ProvinceModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }
}