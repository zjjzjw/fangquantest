<?php namespace App\Src\Surport\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Surport\Domain\Model\CityEntity;
use App\Src\Surport\Domain\Interfaces\CityInterface;
use App\Src\Surport\Domain\Model\CitySpecification;
use App\Src\Surport\Infra\Eloquent\CityModel;


class CityRepository extends Repository implements CityInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param CityEntity $city_entity
     */
    protected function store($city_entity)
    {
        if ($city_entity->isStored()) {
            $model = CityModel::find($city_entity->id);
        } else {
            $model = new CityModel();
        }
        $model->fill(
            [
                'province_id' => $city_entity->province_id,
                'name'        => $city_entity->name,
                'lng'         => $city_entity->lng,
                'lat'         => $city_entity->lat,
            ]
        );
        $model->save();
        $city_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return CityEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = CityModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param CityModel $model
     *
     * @return CityEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new CityEntity();
        $entity->id = $model->id;
        $entity->province_id = $model->province_id;
        $entity->name = $model->name;
        $entity->lng = $model->lng;
        $entity->lat = $model->lat;

        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param CitySpecification $spec
     * @param int               $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(CitySpecification $spec, $per_page = 10)
    {
        $builder = CityModel::query();

        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }

        if ($spec->province_id) {
            $builder->where('province_id', $spec->province_id);
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
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        $collection = collect();
        $builder = CityModel::query();
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }

    public function getCityByProvinceIdAndName($province_id, $name)
    {
        $builder = CityModel::query();
        $builder->where('province_id', $province_id);
        $builder->where('name', 'like', '%' . $name . '%');
        $model = $builder->first();
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    public function getCityByProvinceId($province_id)
    {
        $builder = CityModel::query();
        $builder->where('province_id', $province_id);
        $model = $builder->first();
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param int|array $ids
     */
    public function delete($ids)
    {
        $builder = CityModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }
}