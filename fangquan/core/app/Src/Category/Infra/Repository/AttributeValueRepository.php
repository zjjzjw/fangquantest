<?php namespace App\Src\Category\Infra\Repository;

use App\Src\Category\Domain\Model\AttributeValueSpecification;
use App\Foundation\Domain\Repository;
use App\Src\Category\Domain\Interfaces\AttributeValueInterface;
use App\Src\Category\Domain\Model\AttributeValueEntity;
use App\Src\Category\Infra\Eloquent\AttributeValueModel;


class AttributeValueRepository extends Repository implements AttributeValueInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param AttributeValueEntity $attribute_value_entity
     */
    protected function store($attribute_value_entity)
    {
        if ($attribute_value_entity->isStored()) {
            $model = AttributeValueModel::find($attribute_value_entity->id);
        } else {
            $model = new AttributeValueModel();
        }

        $model->fill(
            [
                'name'         => $attribute_value_entity->name,
                'order'        => $attribute_value_entity->order,
                'attribute_id' => $attribute_value_entity->attribute_id,
            ]
        );
        $model->save();
        $attribute_value_entity->setIdentity($model->id);
    }

    /**
     * @param AttributeValueSpecification $spec
     * @param int                         $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(AttributeValueSpecification $spec, $per_page = 10)
    {
        $builder = AttributeValueModel::query();

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
     * @return AttributeValueModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = AttributeValueModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param AttributeValueModel $model
     *
     * @return AttributeValueEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new AttributeValueEntity();
        $entity->id = $model->id;
        $entity->name = $model->name;
        $entity->order = $model->order;
        $entity->attribute_id = $model->attribute_id;
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
        $builder = AttributeValueModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }


}