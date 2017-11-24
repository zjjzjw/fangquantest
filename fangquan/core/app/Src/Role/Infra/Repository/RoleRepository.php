<?php namespace App\Src\Role\Infra\Repository;

use App\Service\Role\RoleService;
use App\Src\Role\Domain\Interfaces\RoleInterface;
use App\Foundation\Domain\Repository;
use App\Src\Role\Domain\Model\RoleEntity;
use App\Src\Role\Domain\Model\RoleSpecification;
use App\Src\Role\Infra\Eloquent\RoleModel;


class RoleRepository extends Repository implements RoleInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param RoleEntity $role_entity
     */
    protected function store($role_entity)
    {
        if ($role_entity->isStored()) {
            $model = RoleModel::find($role_entity->id);
        } else {
            $model = new RoleModel();
        }
        $model->fill(
            [
                'name' => $role_entity->name,
                'desc' => $role_entity->desc,
            ]
        );
        $model->save();
        if (isset($role_entity->permissions)) {
            $model->permissions()->sync($role_entity->permissions);
        }

        if (isset($role_entity->users)) {
            $model->users()->sync($role_entity->users);
        }
        $role_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return RoleEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = RoleModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param RoleModel $model
     *
     * @return RoleEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new RoleEntity();
        $entity->id = $model->id;
        $entity->name = $model->name;
        $entity->desc = $model->desc;
        $entity->permissions = $model->permissions->pluck('id')->toArray();
        $entity->users = $model->users->pluck('id')->toArray();
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param RoleSpecification $spec
     * @param int               $per_page
     * @return mixed
     */
    public function search(RoleSpecification $spec, $per_page = 10)
    {
        $builder = RoleModel::query();
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
        $builder = RoleModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        /** @var RoleModel $model */
        foreach ($models as $model) {
            $permissions = $model->permissions->pluck('id')->toArray();
            $users = $model->users->pluck('id')->toArray();
            if (!empty($permissions)) {
                $model->permissions()->detach($permissions);
            }

            if (!empty($users)) {
                $model->users()->detach($users);
            }
            $model->delete();
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        $collection = collect();
        $builder = RoleModel::query();
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }
}