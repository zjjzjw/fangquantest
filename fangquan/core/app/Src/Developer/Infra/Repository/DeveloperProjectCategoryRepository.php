<?php namespace App\Src\Developer\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Developer\Domain\Interfaces\DeveloperProjectCategoryInterface;
use App\Src\Developer\Domain\Model\DeveloperProjectCategoryEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectCategorySpecification;
use App\Src\Developer\Infra\Eloquent\DeveloperProjectCategoryModel;

class DeveloperProjectCategoryRepository extends Repository implements DeveloperProjectCategoryInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  DeveloperProjectCategoryEntity $developer_project_category_entity
     */
    protected function store($developer_project_category_entity)
    {
        if ($developer_project_category_entity->isStored()) {
            $model = DeveloperProjectCategoryModel::find($developer_project_category_entity->id);
        } else {
            $model = new DeveloperProjectCategoryModel();
        }
        $model->fill(
            [
                'developer_project_id' => $developer_project_category_entity->developer_project_id,
                'product_category_id'  => $developer_project_category_entity->product_category_id,
            ]
        );
        $model->save();
        $developer_project_category_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return DeveloperProjectCategoryEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = DeveloperProjectCategoryModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return DeveloperEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new DeveloperProjectCategoryEntity();
        $entity->id = $model->id;
        $entity->developer_project_id = $model->developer_project_id;
        $entity->product_category_id = $model->product_category_id;
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
        $builder = DeveloperProjectCategoryModel::query();
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
    public function getDeveloperMainCategoriesByDeveloperProjectId($developer_project_id)
    {
        $builder = DeveloperProjectCategoryModel::query();
        $builder->where('developer_project_id', $developer_project_id);
        $developer_main_category = $builder->get();
        foreach ($developer_main_category as $key => $model) {
            $developer_main_category[$key] = $this->reconstituteFromModel($model)->stored();
        }
        return $developer_main_category;
    }
}