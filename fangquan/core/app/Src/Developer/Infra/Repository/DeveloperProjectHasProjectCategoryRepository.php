<?php namespace App\Src\Developer\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Developer\Domain\Interfaces\DeveloperProjectHasProjectCategoryInterface;
use App\Src\Developer\Domain\Model\DeveloperProjectHasProjectCategoryEntity;
use App\Src\Developer\Infra\Eloquent\DeveloperProjectHasProjectCategoryModel;

class DeveloperProjectHasProjectCategoryRepository extends Repository implements DeveloperProjectHasProjectCategoryInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  DeveloperProjectHasProjectCategoryEntity $developer_project_has_project_category_entity
     */
    protected function store($developer_project_has_project_category_entity)
    {
        if ($developer_project_has_project_category_entity->isStored()) {
            $model = DeveloperProjectHasProjectCategoryModel::find($developer_project_has_project_category_entity->id);
        } else {
            $model = new DeveloperProjectHasProjectCategoryModel();
        }
        $model->fill(
            [
                'developer_project_id' => $developer_project_has_project_category_entity->developer_project_id,
                'project_category_id'  => $developer_project_has_project_category_entity->project_category_id,
            ]
        );
        $model->save();
        $developer_project_has_project_category_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return DeveloperProjectHasProjectCategoryEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = DeveloperProjectHasProjectCategoryModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return DeveloperProjectHasProjectCategoryEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new DeveloperProjectHasProjectCategoryEntity();
        $entity->id = $model->id;
        $entity->developer_project_id = $model->developer_project_id;
        $entity->project_category_id = $model->project_category_id;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param int|array $ids
     */
    public function delete($ids)
    {
        $builder = DeveloperProjectHasProjectCategoryModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @param $developer_project_id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getDeveloperProjectCategoriesByDeveloperProjectId($developer_project_id)
    {
        $collect = collect();
        $builder = DeveloperProjectHasProjectCategoryModel::query();
        $builder->where('developer_project_id', $developer_project_id);
        $models = $builder->get();
        foreach ($models as $key => $model) {
            $collect[] = $this->reconstituteFromModel($model)->stored();
        }
        return $collect;
    }
}