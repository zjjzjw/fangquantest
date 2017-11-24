<?php namespace App\Src\Content\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Content\Domain\Interfaces\ContentCategoryInterface;
use App\Src\Content\Domain\Model\ContentCategoryEntity;
use App\Src\Content\Domain\Model\ContentCategorySpecification;
use App\Src\Content\Infra\Eloquent\ContentCategoryModel;

class ContentCategoryRepository extends Repository implements ContentCategoryInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  ContentCategoryEntity $content_category_entity
     *
     */
    protected function store($content_category_entity)
    {
        if ($content_category_entity->isStored()) {
            $model = ContentCategoryModel::find($content_category_entity->id);
        } else {
            $model = new ContentCategoryModel();
        }
        $model->fill(
            [
                'name'      => $content_category_entity->name,
                'parent_id' => $content_category_entity->parent_id,
                'status'    => $content_category_entity->status,
            ]
        );
        $model->save();
        $content_category_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return ContentCategoryEntity|null
     *
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ContentCategoryModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return ContentCategoryEntity
     *
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ContentCategoryEntity();
        $entity->id = $model->id;
        $entity->name = $model->name;
        $entity->parent_id = $model->parent_id;
        $entity->status = $model->status;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }


    /**
     * @param ContentCategorySpecification $spec
     * @param int                          $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     */
    public function search(ContentCategorySpecification $spec, $per_page = 10)
    {
        $builder = ContentCategoryModel::query();

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
     * @param null|int $status
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     *
     */
    public function ContentFirstCategory()
    {
        $collect = collect();
        $builder = ContentCategoryModel::query();
        $builder->where('parent_id', 0);
        $content_category = $builder->get();
        foreach ($content_category as $key => $model) {
            $collect[$key] = $this->reconstituteFromModel($model)->stored();
        }
        return $collect;
    }

    /**
     * @param null|int $status
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     *
     */
    public function allContentCategory($status = null)
    {
        $collect = collect();
        $builder = ContentCategoryModel::query();
        if ($status) {
            $builder->where('status', $status);
        }
        $content_category = $builder->get();
        foreach ($content_category as $key => $model) {
            $collect[$key] = $this->reconstituteFromModel($model)->stored();
        }
        return $collect;
    }

    /**
     * @param int|array $ids
     */
    public function delete($ids)
    {
        $builder = ContentCategoryModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }


    /**
     * @param int|array $ids
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     *
     */

    public function getContentCategoryByIds($ids)
    {
        $collect = collect();
        if (empty($ids)) {
            return [];
        }
        $builder = ContentCategoryModel::query();
        $builder->whereIn('id', (array)$ids);
        $content_category = $builder->get();
        foreach ($content_category as $key => $model) {
            $collect[$key] = $this->reconstituteFromModel($model)->stored();
        }
        return $collect;
    }

    /**
     * @param int|array      $second_ids
     * @param null|int|array $status
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     *
     */
    public function getThirdContentCategory($second_ids, $status = null)
    {
        $collect = collect();
        $builder = ContentCategoryModel::query();
        if (!empty($status)) {
            $builder->whereIn('status', (array)$status);
        }
        $builder->whereIn('id', (array)$second_ids);
        $content_category = $builder->get();
        foreach ($content_category as $key => $model) {
            $collect[$key] = $this->reconstituteFromModel($model)->stored();
        }
        return $collect;
    }

    /**
     * @param int|array $parent_id
     * @param int|array $status
     * @return array|\Illuminate\Support\Collection
     *
     */
    public function getContentCategoryByParentId($parent_id)
    {
        $collect = collect();
        $builder = ContentCategoryModel::query();
        $builder->where('parent_id', $parent_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


}