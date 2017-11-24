<?php namespace App\Src\Role\Infra\Repository;

use App\Src\Role\Domain\Model\DepartEntity;
use App\Foundation\Domain\Repository;
use App\Src\Role\Domain\Interfaces\DepartInterface;
use App\Src\Role\Domain\Model\DepartSpecification;
use App\Src\Role\Infra\Eloquent\DepartModel;


class DepartRepository extends Repository implements DepartInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param DepartEntity $depart_entity
     */
    protected function store($depart_entity)
    {
        if ($depart_entity->isStored()) {
            $model = DepartModel::find($depart_entity->id);
        } else {
            $model = new DepartModel();
        }
        $model->fill(
            [
                'parent_id' => $depart_entity->parent_id,
                'name'      => $depart_entity->name,
                'level'     => $depart_entity->level,
                'desc'      => $depart_entity->desc,
            ]
        );
        $model->save();
        $depart_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return DepartEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = DepartModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param DepartModel $model
     *
     * @return DepartEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new DepartEntity();
        $entity->id = $model->id;
        $entity->parent_id = $model->parent_id;
        $entity->name = $model->name;
        $entity->level = $model->level;
        $entity->desc = $model->desc;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param DepartSpecification $spec
     * @param int                 $per_page
     * @return mixed
     */
    public function search(DepartSpecification $spec, $per_page = 10)
    {
        $builder = DepartModel::query();
        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }

        $builder->orderBy('created_at', 'desc');

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
     * @param int|array $ids
     */
    public function delete($ids)
    {
        $builder = DepartModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @return array|\Illuminate\Support\Collection
     */
    public function all()
    {
        $collect = collect();
        $builder = DepartModel::query();
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

}