<?php namespace App\Src\Brand\Infra\Repository;

use App\Src\Brand\Domain\Model\CommentSpecification;
use App\Foundation\Domain\Repository;
use App\Src\Brand\Domain\Interfaces\CommentInterface;
use App\Src\Brand\Domain\Model\CommentEntity;
use App\Src\Brand\Infra\Eloquent\CommentModel;


class CommentRepository extends Repository implements CommentInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param CommentEntity $comment_entity
     */
    protected function store($comment_entity)
    {
        if ($comment_entity->isStored()) {
            $model = CommentModel::find($comment_entity->id);
        } else {
            $model = new CommentModel();
        }

        $model->fill(
            [
                'user_id'         => $comment_entity->user_id,
                'type'            => $comment_entity->type,
                'created_user_id' => $comment_entity->created_user_id,
                'content'         => $comment_entity->content,
                'p_id'            => $comment_entity->p_id,
            ]
        );
        $model->save();
        $comment_entity->setIdentity($model->id);
    }

    /**
     * @param CommentSpecification $spec
     * @param int                  $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(CommentSpecification $spec, $per_page = 10)
    {
        $builder = CommentModel::query();

        if ($spec->keyword) {
            $builder->where('brand_name', 'like', '%' . $spec->keyword . '%');
        }

        if ($spec->type) {
            $builder->where('type', $spec->type);
        }

        if ($spec->p_id) {
            $builder->where('p_id', $spec->p_id);
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
     * @return CommentModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = CommentModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param CommentModel $model
     *
     * @return CommentEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new CommentEntity();
        $entity->id = $model->id;

        $entity->user_id = $model->user_id;
        $entity->type = $model->type;
        $entity->content = $model->content;
        $entity->created_user_id = $model->created_user_id;
        $entity->p_id = $model->p_id;
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
        $builder = CommentModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @param $pid
     * @param $type
     * @return array|\Illuminate\Support\Collection
     */
    public function getCommentListByPidAndType($pid, $type)
    {
        $collection = collect();
        $builder = CommentModel::query();
        $builder->where('p_id', $pid);
        $builder->where('type', $type);
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }
}