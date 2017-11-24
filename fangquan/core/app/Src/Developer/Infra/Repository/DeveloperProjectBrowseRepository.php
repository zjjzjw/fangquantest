<?php namespace App\Src\Developer\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Developer\Domain\Interfaces\DeveloperProjectBrowseInterface;
use App\Src\Developer\Domain\Model\DeveloperProjectBrowseEntity;
use App\Src\Developer\Infra\Eloquent\DeveloperProjectBrowseModel;

class DeveloperProjectBrowseRepository extends Repository implements DeveloperProjectBrowseInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  DeveloperProjectBrowseEntity $developer_project_browse_entity
     */
    protected function store($developer_project_browse_entity)
    {
        if ($developer_project_browse_entity->isStored()) {
            $model = DeveloperProjectBrowseModel::find($developer_project_browse_entity->id);
        } else {
            $model = new DeveloperProjectBrowseModel();
        }
        $model->fill(
            [
                'type'    => $developer_project_browse_entity->type,
                'user_id' => $developer_project_browse_entity->user_id,
                'p_id'    => $developer_project_browse_entity->p_id,
            ]
        );
        $model->save();
        $developer_project_browse_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return DeveloperProjectBrowseEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = DeveloperProjectBrowseModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return DeveloperProjectBrowseEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new DeveloperProjectBrowseEntity();
        $entity->id = $model->id;
        $entity->user_id = $model->user_id;
        $entity->type = $model->type;
        $entity->p_id = $model->p_id;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param $user_id
     * @param $p_id
     * @return DeveloperProjectBrowseEntity|null
     */
    public function getUserBrowse($user_id, $p_id)
    {
        $builder = DeveloperProjectBrowseModel::query();
        $builder->where('user_id', $user_id);
        $builder->where('p_id', $p_id);
        $builder->where('type', 1);
        $model = $builder->first();
        /** @var DeveloperProjectBrowseModel $model */
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }
}