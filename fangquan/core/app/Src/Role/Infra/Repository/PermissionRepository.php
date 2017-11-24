<?php namespace App\Src\Role\Infra\Repository;

use App\Src\Role\Domain\Interfaces\PermissionInterface;
use App\Foundation\Domain\Repository;
use App\Src\Role\Domain\Model\DepartSpecification;
use App\Src\Role\Domain\Model\PermissionEntity;
use App\Src\Role\Infra\Eloquent\PermissionModel;


class PermissionRepository extends Repository implements PermissionInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param PermissionEntity $permission_entity
     */
    protected function store($permission_entity)
    {
        if ($permission_entity->isStored()) {
            $model = PermissionModel::find($permission_entity->id);
        } else {
            $model = new PermissionModel();
        }
        $model->fill(
            [
                'name' => $permission_entity->name,
                'code' => $permission_entity->code,
                'desc' => $permission_entity->desc,
            ]
        );
        $model->save();
        $permission_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return PermissionEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = PermissionModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param PermissionModel $model
     *
     * @return PermissionEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new PermissionEntity();
        $entity->id = $model->id;
        $entity->name = $model->name;
        $entity->code = $model->code;
        $entity->desc = $model->desc;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
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
        $builder = PermissionModel::query();
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param     $spec
     * @param int $per_page
     * @return mixed
     */
    public function search(DepartSpecification $spec, $per_page = 10)
    {
        $builder = PermissionModel::query();
        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }
        $builder->orderBy('id', 'asc');

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

}