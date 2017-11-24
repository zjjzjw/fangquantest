<?php namespace App\Src\Category\Infra\Repository;

use App\Src\Category\Domain\Model\CategoryParamSpecification;
use App\Foundation\Domain\Repository;
use App\Src\Category\Domain\Interfaces\CategoryParamInterface;
use App\Src\Category\Domain\Model\CategoryParamEntity;
use App\Src\Category\Infra\Eloquent\CategoryParamModel;


class CategoryParamRepository extends Repository implements CategoryParamInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param CategoryParamEntity $category_param_entity
     */
    protected function store($category_param_entity)
    {
        if ($category_param_entity->isStored()) {
            $model = CategoryParamModel::find($category_param_entity->id);
        } else {
            $model = new CategoryParamModel();
        }

        $model->fill(
            [
                'name'        => $category_param_entity->name,
                'category_id' => $category_param_entity->category_id,
            ]
        );
        $model->save();
        $category_param_entity->setIdentity($model->id);
    }

    /**
     * @param CategoryParamSpecification $spec
     * @param int                        $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(CategoryParamSpecification $spec, $per_page = 10)
    {
        $builder = CategoryParamModel::query();

        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
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
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return CategoryParamModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = CategoryParamModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param CategoryParamModel $model
     *
     * @return CategoryParamEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new CategoryParamEntity();
        $entity->id = $model->id;

        $entity->category_id = $model->category_id;
        $entity->name = $model->name;
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
        $builder = CategoryParamModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }


}