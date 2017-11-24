<?php namespace App\Src\Product\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Product\Domain\Interfaces\ProductCategoryInterface;
use App\Src\Product\Domain\Model\ProductCategoryEntity;
use App\Src\Product\Domain\Model\ProductCategorySpecification;
use App\Src\Product\Infra\Eloquent\ProductCategoryModel;

class ProductCategoryRepository extends Repository implements ProductCategoryInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  ProductCategoryEntity $product_category_entity
     */
    protected function store($product_category_entity)
    {
        if ($product_category_entity->isStored()) {
            $model = ProductCategoryModel::find($product_category_entity->id);
        } else {
            $model = new ProductCategoryModel();
        }
        $model->fill(
            [
                'name'        => $product_category_entity->name,
                'parent_id'   => $product_category_entity->parent_id,
                'status'      => $product_category_entity->status,
                'sort'        => $product_category_entity->sort,
                'description' => $product_category_entity->description,
                'attribfield' => $product_category_entity->attribfield,
                'is_leaf'     => $product_category_entity->is_leaf,
                'level'       => $product_category_entity->level,
                'icon'        => $product_category_entity->icon,
                'logo'        => $product_category_entity->logo,
            ]
        );
        $model->save();
        $product_category_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return ProductCategoryEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProductCategoryModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return ProductCategoryEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProductCategoryEntity();
        $entity->id = $model->id;
        $entity->name = $model->name;
        $entity->parent_id = $model->parent_id;
        $entity->status = $model->status;
        $entity->sort = $model->sort;
        $entity->description = $model->description;
        $entity->attribfield = $model->attribfield;
        $entity->is_leaf = $model->is_leaf;
        $entity->level = $model->level;
        $entity->icon = $model->icon;
        $entity->logo = $model->logo;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }


    /**
     * @param ProductCategorySpecification $spec
     * @param int                          $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ProductCategorySpecification $spec, $per_page = 10)
    {
        $builder = ProductCategoryModel::query();

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

    public function treeDataList($all_data)
    {
        $data = $this->recursion($all_data, 0);

        return $data;
    }

    public function recursion($data, $parent)
    {
        $return_data = [];
        foreach ($data as $k => $v) {
            if ($v['parent_id'] == $parent) {
                $v['results'] = $this->recursion($data, $v['id']);
                $return_data[] = $v;
            }
        }
        if (count($return_data) == 0) {
            return null;
        }
        return $return_data;
    }


    /**
     * @param null|int $status
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function allProductCategory($status = null)
    {
        $builder = ProductCategoryModel::query();
        if (!is_null($status)) {
            $builder->where('status', $status);
        }
        $product_category = $builder->get();
        foreach ($product_category as $key => $model) {
            $product_category[$key] = $this->reconstituteFromModel($model)->stored();
        }
        return $product_category;
    }


    /**
     * @param null $limit
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getCategoryList($limit = null)
    {
        $builder = ProductCategoryModel::query();
        $builder->where('parent_id', 1);
        $builder->orderby('sort', 'asc');
        if (isset($limit)) {
            $builder->limit($limit);
        }
        $category = $builder->get();
        foreach ($category as $key => $model) {
            $category[$key] = $this->reconstituteFromModel($model)->stored();
        }
        return $category;
    }

    /**
     * @param int|array $ids
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getProductCategoryByIds($ids)
    {
        if (empty($ids)) return [];
        $builder = ProductCategoryModel::query();
        $builder->whereIn('id', (array)$ids);
        $product_category = $builder->get();
        foreach ($product_category as $key => $model) {
            $product_category[$key] = $this->reconstituteFromModel($model)->stored();
        }
        return $product_category;
    }

    /**
     * @param int|array      $second_ids
     * @param null|int|array $status
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getThirdProductCategory($second_ids, $status = null)
    {
        $builder = ProductCategoryModel::query();
        if (!empty($status)) {
            $builder->whereIn('status', (array)$status);
        }
        $builder->whereIn('id', (array)$second_ids);
        $builder->where('level', 2);
        $product_category = $builder->get();
        foreach ($product_category as $key => $model) {
            $product_category[$key] = $this->reconstituteFromModel($model)->stored();
        }
        return $product_category;
    }

    /**
     * @param int|array      $second_ids
     * @param null|int|array $status
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getProductCategoryByIdsAndLevel($ids, $status = null)
    {
        $builder = ProductCategoryModel::query();
        if (!empty($status)) {
            $builder->whereIn('status', (array)$status);
        }
        $builder->whereIn('id', (array)$ids);
        $builder->where('level', 2);
        $product_category = $builder->get();
        foreach ($product_category as $key => $model) {
            $product_category[$key] = $this->reconstituteFromModel($model)->stored();
        }
        return $product_category;
    }

    /**
     * 根据level获取产品分类
     * @param      $level
     * @param null $status
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getProductCategoryByLevel($level, $status = null)
    {
        $builder = ProductCategoryModel::query();
        $builder->where('level', $level);
        $builder->where('status', $status);
        $product_category = $builder->get();
        foreach ($product_category as $key => $model) {
            $product_category[$key] = $this->reconstituteFromModel($model)->stored();
        }
        return $product_category;
    }


    /**
     * @param int|array $parent_id
     * @param int|array $status
     * @return array|\Illuminate\Support\Collection
     */
    public function getProductCategoryByParentId($parent_id, $status)
    {
        $collect = collect();
        $builder = ProductCategoryModel::query();
        $builder->whereIn('parent_id', (array)$parent_id);
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
    public function getProductCategoryByLevelAndStatus($level, $status = null)
    {
        $collect = collect();
        $builder = ProductCategoryModel::query();
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
