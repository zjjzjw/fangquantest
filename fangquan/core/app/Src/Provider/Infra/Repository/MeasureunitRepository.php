<?php namespace App\Src\Provider\Infra\Repository;

use App\Src\Provider\Domain\Interfaces\MeasureunitInterface;
use App\Src\Provider\Infra\Eloquent\MeasureunitModel;
use App\Src\Provider\Domain\Model\MeasureunitEntity;
use App\Foundation\Domain\Repository;

class MeasureunitRepository extends Repository implements MeasureunitInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  MeasureunitEntity $measureunit_entity
     */
    protected function store($measureunit_entity)
    {
        if ($measureunit_entity->isStored()) {
            $model = MeasureunitModel::find($measureunit_entity->id);
        } else {
            $model = new MeasureunitModel();
        }
        $model->fill(
            [
                'name' => $measureunit_entity->name,
            ]
        );
        $model->save();
        $measureunit_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return MeasureunitEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = MeasureunitModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return MeasureunitEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new MeasureunitEntity();
        $entity->id = $model->id;
        $entity->name = $model->name;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }


    /**
     * @return array|\Illuminate\Support\Collection
     */
    public function all()
    {
        $collect = collect();
        $builder = MeasureunitModel::query();
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

}