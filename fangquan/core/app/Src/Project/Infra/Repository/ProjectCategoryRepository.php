<?php namespace App\Src\Project\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Project\Domain\Interfaces\ProjectCategoryInterface;
use App\Src\Project\Domain\Model\ProjectCategoryEntity;
use App\Src\Project\Domain\Model\ProjectCategorySpecification;
use App\Src\Project\Infra\Eloquent\ProjectCategoryModel;

class ProjectCategoryRepository extends Repository implements ProjectCategoryInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  ProjectCategoryEntity $project_category_entity
     */
    protected function store($project_category_entity)
    {
        if ($project_category_entity->isStored()) {
            $model = ProjectCategoryModel::find($project_category_entity->id);
        } else {
            $model = new ProjectCategoryModel();
        }
        $model->fill(
            [
                'name'        => $project_category_entity->name,
                'parent_id'   => $project_category_entity->parent_id,
                'status'      => $project_category_entity->status,
                'sort'        => $project_category_entity->sort,
                'description' => $project_category_entity->description,
                'attribfield' => $project_category_entity->attribfield,
                'is_leaf'     => $project_category_entity->is_leaf,
                'level'       => $project_category_entity->level,
                'logo'        => $project_category_entity->logo,
                'icon_font'   => $project_category_entity->icon_font,
            ]
        );
        $model->save();
        $project_category_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return ProjectCategoryEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProjectCategoryModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return ProjectCategoryEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProjectCategoryEntity();
        $entity->id = $model->id;
        $entity->name = $model->name;
        $entity->parent_id = $model->parent_id;
        $entity->status = $model->status;
        $entity->sort = $model->sort;
        $entity->description = $model->description;
        $entity->attribfield = $model->attribfield;
        $entity->is_leaf = $model->is_leaf;
        $entity->level = $model->level;
        $entity->logo = $model->logo;
        $entity->icon_font = $model->icon_font;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }


    /**
     * @param ProjectCategorySpecification $spec
     * @param int                          $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ProjectCategorySpecification $spec, $per_page = 10)
    {
        $builder = ProjectCategoryModel::query();

        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }
        if ($spec->column && $spec->sort) {
            $builder->orderBy($spec->column, $spec->sort);
        } else {
            $builder->orderBy('created_at', 'asc');
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
     * @param null|int $status
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function allProjectCategory($status = null)
    {
        $collect = collect();
        $builder = ProjectCategoryModel::query();
        if (!is_null($status)) {
            $builder->where('status', $status);
        }
        $models = $builder->get();
        foreach ($models as $key => $model) {
            $collect[$key] = $this->reconstituteFromModel($model)->stored();
        }
        return $collect;
    }


    /**
     * @param int|array $ids
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getProjectCategoryByIds($ids)
    {
        if (empty($ids)) return [];
        $builder = ProjectCategoryModel::query();
        $builder->whereIn('id', (array)$ids);
        $project_category = $builder->get();
        foreach ($project_category as $key => $model) {
            $project_category[$key] = $this->reconstituteFromModel($model)->stored();
        }
        return $project_category;
    }

    /**
     * @param int|array      $second_ids
     * @param null|int|array $status
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getThirdProjectCategory($second_ids, $status = null)
    {
        $builder = ProjectCategoryModel::query();
        if (!empty($status)) {
            $builder->whereIn('status', (array)$status);
        }
        $builder->whereIn('id', (array)$second_ids);
        $builder->where('level', 2);
        $project_category = $builder->get();
        foreach ($project_category as $key => $model) {
            $project_category[$key] = $this->reconstituteFromModel($model)->stored();
        }
        return $project_category;
    }

    /**
     * @param int|array      $second_ids
     * @param null|int|array $status
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getProjectCategoryByIdsAndLevel($ids, $status = null)
    {
        $builder = ProjectCategoryModel::query();
        if (!empty($status)) {
            $builder->whereIn('status', (array)$status);
        }
        $builder->whereIn('id', (array)$ids);
        $builder->where('level', 2);
        $project_category = $builder->get();
        foreach ($project_category as $key => $model) {
            $project_category[$key] = $this->reconstituteFromModel($model)->stored();
        }
        return $project_category;
    }


    /**
     * @param int|array $parent_id
     * @param int|array $status
     * @return array|\Illuminate\Support\Collection
     */
    public function getProjectCategoryByParentId($parent_id, $status)
    {
        $collect = collect();
        $builder = ProjectCategoryModel::query();
        if ($parent_id){
            $builder->whereIn('parent_id', (array)$parent_id);
        }
        $builder->whereIn('status', (array)$status);
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param int|array      $level
     * @param null|int|array $status
     * @return array|\Illuminate\Support\Collection
     */
    public function getProjectCategoryByLevelAndStatus($level, $status = null)
    {
        $collect = collect();
        $builder = ProjectCategoryModel::query();
        $builder->whereIn('level', (array)$level);
        if (!empty($status)) {
            $builder->whereIn('status', (array)$status);
        }
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

}
