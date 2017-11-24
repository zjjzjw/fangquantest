<?php namespace App\Src\Tag\Infra\Repository;

use App\Src\Tag\Domain\Model\TagSpecification;
use App\Foundation\Domain\Repository;
use App\Src\Tag\Domain\Interfaces\TagInterface;
use App\Src\Tag\Domain\Model\TagEntity;
use App\Src\Tag\Infra\Eloquent\TagModel;


class TagRepository extends Repository implements TagInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param TagEntity $tag_entity
     */
    protected function store($tag_entity)
    {
        if ($tag_entity->isStored()) {
            $model = TagModel::find($tag_entity->id);
        } else {
            $model = new TagModel();
        }

        $model->fill(
            [
                'name'            => $tag_entity->name,
                'order'           => $tag_entity->order,
                'created_user_id' => $tag_entity->created_user_id,
                'type'            => $tag_entity->type,
            ]
        );
        $model->save();
        $tag_entity->setIdentity($model->id);
    }

    /**
     * @param TagSpecification $spec
     * @param int              $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(TagSpecification $spec, $per_page = 10)
    {
        $builder = TagModel::query();

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
     * @return TagModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = TagModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param TagModel $model
     *
     * @return TagEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new TagEntity();
        $entity->id = $model->id;

        $entity->name = $model->name;
        $entity->created_user_id = $model->created_user_id;
        $entity->order = $model->order;
        $entity->type = $model->type;
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
        $builder = TagModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @return array|\Illuminate\Support\Collection
     */
    public function all()
    {
        $collection = collect();
        $builder = TagModel::query();
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }
}