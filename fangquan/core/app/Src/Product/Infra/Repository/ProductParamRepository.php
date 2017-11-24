<?php namespace App\Src\Product\Infra\Repository;

use App\Src\Product\Domain\Model\ProductParamSpecification;
use App\Foundation\Domain\Repository;
use App\Src\Product\Domain\Interfaces\ProductParamInterface;
use App\Src\Product\Domain\Model\ProductParamEntity;
use App\Src\Product\Infra\Eloquent\ProductParamModel;


class ProductParamRepository extends Repository implements ProductParamInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ProductParamEntity $comment_entity
     */
    protected function store($comment_entity)
    {
        if ($comment_entity->isStored()) {
            $model = ProductParamModel::find($comment_entity->id);
        } else {
            $model = new ProductParamModel();
        }

        $model->fill(
            [
                'product_id' => $comment_entity->product_id,
                'name'       => $comment_entity->name,
                'value'      => $comment_entity->value,
            ]
        );
        $model->save();
        $comment_entity->setIdentity($model->id);
    }

    /**
     * @param ProductParamSpecification $spec
     * @param int                       $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ProductParamSpecification $spec, $per_page = 10)
    {
        $builder = ProductParamModel::query();

        if ($spec->keyword) {
            $builder->where('brand_name', 'like', '%' . $spec->keyword . '%');
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
     * @return ProductParamModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProductParamModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProductParamModel $model
     *
     * @return ProductParamEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProductParamEntity();
        $entity->id = $model->id;

        $entity->product_id = $model->product_id;
        $entity->name = $model->name;
        $entity->value = $model->value;
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
        $builder = ProductParamModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }


}