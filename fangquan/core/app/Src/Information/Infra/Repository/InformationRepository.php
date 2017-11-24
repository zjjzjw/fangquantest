<?php namespace App\Src\Information\Infra\Repository;

use App\Src\Information\Domain\Model\InformationPublishStatus;
use App\Src\Information\Domain\Model\InformationSpecification;
use App\Foundation\Domain\Repository;
use App\Src\Information\Domain\Interfaces\InformationInterface;
use App\Src\Information\Domain\Model\InformationEntity;
use App\Src\Information\Infra\Eloquent\InformationModel;


class InformationRepository extends Repository implements InformationInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param InformationEntity $information_entity
     */
    protected function store($information_entity)
    {
        if ($information_entity->isStored()) {
            $model = InformationModel::find($information_entity->id);
        } else {
            $model = new InformationModel();
        }

        $model->fill(
            [
                'title'           => $information_entity->title,
                'thumbnail'       => $information_entity->thumbnail,
                'publish_at'      => $information_entity->publish_at,
                'tag_id'          => $information_entity->tag_id,
                'content'         => $information_entity->content,
                'order'           => $information_entity->order,
                'status'          => $information_entity->status,
                'created_user_id' => $information_entity->created_user_id,
                'author'          => $information_entity->author,
                'product_id'      => $information_entity->product_id,
                'comment_count'   => $information_entity->comment_count,
                'is_publish'      => $information_entity->is_publish,
            ]
        );
        $model->save();
        if (!empty($information_entity->information_brands)) {
            $model->information_brands()->sync($information_entity->information_brands);
        }
        if (!empty($information_entity->information_categorys)) {
            $model->information_categorys()->sync($information_entity->information_categorys);
        }
        if (!empty($information_entity->information_themes)) {
            $model->information_themes()->sync($information_entity->information_themes);
        }
        $information_entity->setIdentity($model->id);
    }

    /**
     * @param InformationSpecification $spec
     * @param int                      $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(InformationSpecification $spec, $per_page = 10)
    {
        $builder = InformationModel::query();
        if ($spec->tag_id) {
            $builder->where('information.tag_id', $spec->tag_id);
        }
        if ($spec->status) {
            $builder->where('information.status', $spec->status);
        }
        if ($spec->keyword) {
            $builder->where('information.title', 'like', '%' . $spec->keyword . '%');
        }
        if ($spec->theme_id) {
            $builder->leftJoin('information_theme', function ($join) {
                $join->on('information_theme.information_id', '=', 'information.id');
            });
            $builder->where('information_theme.theme_id', $spec->theme_id);
        }
        if ($spec->product_id) {
            $builder->where('product_id', $spec->product_id);
        }
        if ($spec->category_id) {
            $builder->leftJoin('information_category', function ($join) {
                $join->on('information_category.information_id', '=', 'information.id');
            });
            $builder->where('information_category.category_id', $spec->category_id);
        }
        if ($spec->brand_id) {
            $builder->leftJoin('information_brand', function ($join) {
                $join->on('information_brand.information_id', '=', 'information.id');
            });
            $builder->where('information_brand.brand_id', $spec->brand_id);
        }

        $builder->orderByDesc('information.id');
        $builder->select('information.*');
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
     * @return InformationModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = InformationModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param InformationModel $model
     *
     * @return InformationEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new InformationEntity();
        $entity->id = $model->id;

        $entity->title = $model->title;
        $entity->thumbnail = $model->thumbnail;
        $entity->publish_at = $model->publish_at;
        $entity->tag_id = $model->tag_id;
        $entity->content = $model->content;
        $entity->order = $model->order;
        $entity->author = $model->author;
        $entity->comment_count = $model->comment_count;
        $entity->status = $model->status;
        $entity->is_publish = $model->is_publish;
        $entity->created_user_id = $model->created_user_id;
        $entity->information_brands = $model->information_brands->pluck('id')->toArray();
        $entity->information_categorys = $model->information_categorys->pluck('id')->toArray();
        $entity->information_themes = $model->information_themes->pluck('id')->toArray();
        $entity->product_id = $model->product_id;
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
        $builder = InformationModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        /** @var InformationModel $model */
        foreach ($models as $model) {

            $information_brands = $model->information_brands->pluck('id')->toArray();
            if (!empty($information_brands)) {
                $model->information_brands()->detach($information_brands);
            }

            $information_themes = $model->information_themes->pluck('id')->toArray();
            if (!empty($information_themes)) {
                $model->information_themes()->detach($information_themes);
            }

            $information_categorys = $model->information_categorys->pluck('id')->toArray();
            if (!empty($information_categorys)) {
                $model->information_categorys()->detach($information_categorys);
            }

            $model->delete();
        }
    }

    /**
     * @param  int $id
     */
    public function updateCommentCount($id)
    {
        /** @var InformationEntity $entity */
        $entity = $this->fetch($id);
        if (isset($entity)) {
            $entity->comment_count = $entity->comment_count + 1;
            $this->save($entity);
        }
    }

    public function getInformationListByCategoryId($category_id, $limit, $status)
    {
        $collection = collect();
        $builder = InformationModel::query();
        $builder->leftJoin('information_category', function ($join) {
            $join->on('information_category.information_id', '=', 'information.id');
        });
        $builder->where('information_category.category_id', $category_id);
        $builder->where('information.status', $status);
        $builder->limit($limit);
        $builder->select('information.*');
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }

    public function getInformationListByBrandId($brand_id, $status)
    {
        $collection = collect();
        $builder = InformationModel::query();
        $builder->leftJoin('information_brand', function ($join) {
            $join->on('information_brand.information_id', '=', 'information.id');
        });
        $builder->where('information_brand.brand_id', $brand_id);
        $builder->where('information.status', $status);
        $builder->select('information.*');
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }


    public function getInformationListByProductId($product_id, $limit, $status)
    {
        $collection = collect();
        $builder = InformationModel::query();
        $builder->where('product_id', $product_id);
        $builder->where('information.status', $status);
        $builder->limit($limit);
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }

    public function getInformationListByPublishTime($time)
    {
        $collection = collect();
        $builder = InformationModel::query();
        $builder->where('publish_at', '<', $time);
        $builder->where('is_publish', InformationPublishStatus::YES);
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }
}