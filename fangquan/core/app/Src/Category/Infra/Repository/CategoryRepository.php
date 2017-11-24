<?php namespace App\Src\Category\Infra\Repository;

use App\Src\Category\Domain\Model\CategorySpecification;
use App\Foundation\Domain\Repository;
use App\Src\Category\Domain\Interfaces\CategoryInterface;
use App\Src\Category\Domain\Model\CategoryEntity;
use App\Src\Category\Infra\Eloquent\CategoryModel;
use App\Src\Category\Infra\Eloquent\CategoryParamModel;


class CategoryRepository extends Repository implements CategoryInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param CategoryEntity $category_entity
     */
    protected function store($category_entity)
    {
        if ($category_entity->isStored()) {
            $model = CategoryModel::find($category_entity->id);
        } else {
            $model = new CategoryModel();
        }

        $model->fill(
            [
                'name'            => $category_entity->name,
                'parent_id'       => $category_entity->parent_id,
                'order'           => $category_entity->order,
                'status'          => $category_entity->status,
                'price'           => $category_entity->price,
                'image_id'        => $category_entity->image_id,
                'created_user_id' => $category_entity->created_user_id,
                'icon_font'       => $category_entity->icon_font,
            ]
        );
        $model->save();

        if (!empty($category_entity->category_attributes)) {
            $model->category_attributes()->sync($category_entity->category_attributes);
        }

        if (!empty($category_entity->category_params)) {
            $this->saveCategoryParams($model, $category_entity->category_params, $category_entity->category_attribute_ids);
        }
        $category_entity->setIdentity($model->id);
    }

    /**
     * @param CategoryModel $model
     * @param               $category_params
     * @param               $category_attribute_ids
     */
    protected function saveCategoryParams($model, $category_params, $category_attribute_ids)
    {
        $category_param_repository = new CategoryParamRepository();
        $builder = CategoryParamModel::query();
        $builder->whereNotIn('id', $category_attribute_ids);
        $builder->where('category_id', $model->id);
        $category_ids = $builder->pluck('id')->toArray();
        if (!empty($category_ids)) {
            $category_param_repository->delete($category_ids);
        }
        foreach ($category_params as $key => $category_param) {
            if (isset($category_attribute_ids[$key]) && !empty($category_attribute_ids[$key])) {
                $category_param_model = CategoryParamModel::find($category_attribute_ids[$key]);
            } else {
                $category_param_model = new CategoryParamModel();
            }
            $category_param_model->category_id = $model->id;
            $category_param_model->name = $category_param;
            $category_param_model->save();
        }
    }

    /**
     * @param CategorySpecification $spec
     * @param int                   $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(CategorySpecification $spec, $per_page = 10)
    {
        $builder = CategoryModel::query();

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
     * @return CategoryModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = CategoryModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param CategoryModel $model
     *
     * @return CategoryEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new CategoryEntity();
        $entity->id = $model->id;

        $entity->parent_id = $model->parent_id;
        $entity->name = $model->name;
        $entity->order = $model->order;
        $entity->status = $model->status;
        $entity->image_id = $model->image_id;
        $entity->price = $model->price;
        $entity->created_user_id = $model->created_user_id;
        $entity->icon_font = $model->icon_font;
        $entity->category_attributes = $model->category_attributes->pluck('name', 'id')->toArray();
        $entity->category_params = $model->category_params->pluck('name', 'id')->toArray();
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
        $builder = CategoryModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        $category_param_repository = new CategoryParamRepository();
        /** @var CategoryModel $model */
        foreach ($models as $model) {
            $category_attributes = $model->category_attributes->pluck('id')->toArray();
            $category_params = $model->category_params()->pluck('id')->toArray();
            if (!empty($category_attributes)) {
                $model->category_attributes()->detach($category_attributes);
            }
            if (!empty($category_params)) {
                $category_param_repository->delete($category_params);
            }
            $model->delete();
        }
    }

    /**
     * @param null $status
     * @return array|\Illuminate\Support\Collection
     */
    public function all($status = null)
    {
        $collection = collect();
        $builder = CategoryModel::query();
        if ($status) {
            $builder->where('status', $status);
        }
        $builder->orderBy('order');
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }

    /**
     * @param $category_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getLevelCategorys($category_id)
    {
        $collection = collect();
        $builder = CategoryModel::query();
        $builder->where('parent_id', $category_id);
        $builder->orderBy('order');
        $models = $builder->get();
        /** @var CategoryModel $model */
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }

    /**
     * @param int|array $ids
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getProductCategoryByIds($ids)
    {
        if (empty($ids)) return [];
        $builder = CategoryModel::query();
        $builder->whereIn('id', (array)$ids);
        $category = $builder->get();
        /**
         * @var               $key
         * @var CategoryModel $model
         */
        foreach ($category as $key => $model) {
            $category[$key] = $this->reconstituteFromModel($model)->stored();
        }
        return $category;
    }
}