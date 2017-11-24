<?php namespace App\Src\Surport\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Surport\Domain\Interfaces\ChinaAreaInterface;
use App\Src\Surport\Domain\Model\ChinaAreaEntity;
use App\Src\Surport\Domain\Model\ChinaAreaSpecification;
use App\Src\Surport\Domain\Model\CityEntity;
use App\Src\Surport\Domain\Interfaces\CityInterface;
use App\Src\Surport\Infra\Eloquent\ChinaAreaModel;
use App\Src\Surport\Infra\Eloquent\CityModel;


class ChinaAreaRepository extends Repository implements ChinaAreaInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ChinaAreaEntity $area_entity
     */
    protected function store($area_entity)
    {
        if ($area_entity->isStored()) {
            $model = ChinaAreaModel::find($area_entity->id);
        } else {
            $model = new ChinaAreaModel();
        }
        $model->fill(
            [
                'name' => $area_entity->name,
            ]
        );
        $model->save();
        $area_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return ChinaAreaEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ChinaAreaModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ChinaAreaSpecification $spec
     * @param int                    $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ChinaAreaSpecification $spec, $per_page = 10)
    {
        $builder = ChinaAreaModel::query();

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
     * @param ChinaAreaModel $model
     *
     * @return ChinaAreaEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ChinaAreaEntity();
        $entity->id = $model->id;
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
        $builder = ChinaAreaModel::query();
        $models = $builder->get();
        /** @var ChinaAreaModel $model */
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
        $builder = ChinaAreaModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }
}