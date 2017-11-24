<?php namespace App\Src\Role\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Role\Domain\Interfaces\WagePasswordInterface;
use App\Src\Role\Domain\Model\WagePasswordEntity;
use App\Src\Role\Domain\Model\WagePasswordSpecification;
use App\Src\Role\Infra\Eloquent\WagePasswordModel;


class WagePasswordRepository extends Repository implements WagePasswordInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param WagePasswordEntity $wage_password_entity
     */
    protected function store($wage_password_entity)
    {
        if ($wage_password_entity->isStored()) {
            $model = WagePasswordModel::find($wage_password_entity->id);
        } else {
            $model = new WagePasswordModel();
        }

        $model->fill(
            [
                'user_id'  => $wage_password_entity->user_id,
                'password' => $wage_password_entity->password,
            ]
        );
        $model->save();
        $wage_password_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return WagePasswordModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = WagePasswordModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param WagePasswordModel $model
     *
     * @return WagePasswordEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new WagePasswordEntity();
        $entity->id = $model->id;
        $entity->user_id = $model->user_id;
        $entity->password = $model->password;

        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param WagePasswordSpecification $spec
     * @param int                       $per_page
     * @return mixed
     */
    public function search(WagePasswordSpecification $spec, $per_page = 10)
    {
        $builder = WagePasswordModel::query();
        if ($spec->keyword) {
            $builder->where('user_id', 'like', '%' . $spec->keyword . '%');
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
        $builder = WagePasswordModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }


    /**
     * @param int $user_id
     * return $mixed
     */
    public function getPasswordByUserId($user_id)
    {
        $builder = WagePasswordModel::query();
        $builder->where('user_id', $user_id);
        $model = $builder->first();
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

}