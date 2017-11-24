<?php namespace App\Src\Role\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Role\Domain\Interfaces\UserFeedbackInterface;
use App\Src\Role\Domain\Model\UserFeedbackEntity;
use App\Src\Role\Domain\Model\UserFeedbackSpecification;
use App\Src\Role\Infra\Eloquent\UserFeedbackModel;


class UserFeedbackRepository extends Repository implements UserFeedbackInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param UserFeedbackEntity $user_feedback_entity
     */
    protected function store($user_feedback_entity)
    {
        if ($user_feedback_entity->isStored()) {
            $model = UserFeedbackModel::find($user_feedback_entity->id);
        } else {
            $model = new UserFeedbackModel();
        }
        $model->fill(
            [
                'user_id' => $user_feedback_entity->user_id,
                'contact' => $user_feedback_entity->contact,
                'content' => $user_feedback_entity->content,
            ]
        );
        $model->save();
        $user_feedback_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return \App\Src\Role\Domain\Model\UserFeedBackEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = UserFeedbackModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return \App\Src\Role\Domain\Model\UserFeedbackEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new UserFeedBackEntity();
        $entity->id = $model->id;
        $entity->user_id = $model->user_id;
        $entity->contact = $model->contact;
        $entity->content = $model->content;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;

        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }


    /**
     * @param UserFeedbackSpecification $spec
     * @return mixed
     */
    public function search(UserFeedbackSpecification $spec, $per_page = 10)
    {
        $builder = UserFeedbackModel::query();
        if ($spec->start_time) {
            $builder->where('created_at', '>=', $spec->start_time->startOfDay());
        }
        if ($spec->end_time) {
            $builder->where('created_at', '<=', $spec->end_time->endOfDay());
        }
        if ($spec->keyword) {
            $builder->where('content', 'like', '%' . $spec->keyword . '%');
        }

        $builder->orderBy('created_at', 'desc');

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


}