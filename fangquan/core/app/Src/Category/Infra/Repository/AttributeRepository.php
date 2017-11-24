<?php namespace App\Src\Category\Infra\Repository;

use App\Src\Category\Domain\Model\AttributeSpecification;
use App\Foundation\Domain\Repository;
use App\Src\Category\Domain\Interfaces\AttributeInterface;
use App\Src\Category\Domain\Model\AttributeEntity;
use App\Src\Category\Infra\Eloquent\AttributeModel;
use App\Src\Category\Infra\Eloquent\AttributeValueModel;


class AttributeRepository extends Repository implements AttributeInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param AttributeEntity $attribute_entity
     */
    protected function store($attribute_entity)
    {
        if ($attribute_entity->isStored()) {
            $model = AttributeModel::find($attribute_entity->id);
        } else {
            $model = new AttributeModel();
        }

        $model->fill(
            [
                'name'        => $attribute_entity->name,
                'order'       => $attribute_entity->order,
                'category_id' => $attribute_entity->category_id,
            ]
        );
        $model->save();

        if (!empty($attribute_entity->attribute_values)) {
            $this->saveAttributeValue($model, $attribute_entity->attribute_values, $attribute_entity->attribute_value_ids);
        }

        $attribute_entity->setIdentity($model->id);
    }

    /**
     * @param AttributeModel $model
     * @param                $attribute_values
     * @param                $attribute_value_ids
     */
    protected function saveAttributeValue($model, $attribute_values, $attribute_value_ids)
    {
        $attribute_value_repository = new AttributeValueRepository();
        $builder = AttributeValueModel::query();
        $builder->whereNotIn('id', $attribute_value_ids);
        $builder->where('attribute_id', $model->id);
        $value_ids = $builder->pluck('id')->toArray();
        if (!empty($value_ids)) {
            $attribute_value_repository->delete($value_ids);
        }
        foreach ($attribute_values as $key => $attribute_value) {
            if (isset($attribute_value_ids[$key]) && !empty($attribute_value_ids[$key])) {
                $attribute_value_model = AttributeValueModel::find($attribute_value_ids[$key]);
            } else {
                $attribute_value_model = new AttributeValueModel();
            }
            $attribute_value_model->attribute_id = $model->id;
            $attribute_value_model->name = $attribute_value;
            $attribute_value_model->save();
        }
    }

    /**
     * @param AttributeSpecification $spec
     * @param int                    $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(AttributeSpecification $spec, $per_page = 10)
    {
        $builder = AttributeModel::query();

        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }
        if ($spec->category_id) {
            $builder->where('category_id', $spec->category_id);
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
     * @return AttributeModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = AttributeModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param AttributeModel $model
     *
     * @return AttributeEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new AttributeEntity();
        $entity->id = $model->id;
        $entity->name = $model->name;
        $entity->order = $model->order;
        $entity->category_id = $model->category_id;
        $entity->attribute_values = $model->attribute_values->pluck('name', 'id')->toArray();
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
        $builder = AttributeModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        $attribute_value_repository = new AttributeValueRepository();
        foreach ($models as $model) {
            $attribute_values = $model->attribute_values()->pluck('id')->toArray();
            if (!empty($attribute_values)) {
                $attribute_value_repository->delete($attribute_values);
            }
            $model->delete();
        }
    }

    /**
     * @return array|\Illuminate\Support\Collection
     */
    public function all()
    {
        $collection = collect();
        $builder = AttributeModel::query();
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }


    /**
     * @param int $category_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getAttributeByCategoryId($category_id)
    {
        $collection = collect();
        $builder = AttributeModel::query();
        $builder->where('category_id', $category_id);
        $models = $builder->get();
        /** @var AttributeModel $model */
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }

}