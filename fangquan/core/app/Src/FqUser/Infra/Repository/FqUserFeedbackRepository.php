<?php namespace App\Src\FqUser\Infra\Repository;

use App\Foundation\Domain\Repository;

use App\Src\FqUser\Domain\Interfaces\FqUserFeedbackInterface;
use App\Src\FqUser\Domain\Model\FqUserFeedbackEntity;
use App\Src\FqUser\Domain\Model\FqUserFeedbackSpecification;
use App\Src\FqUser\Infra\Eloquent\FqUserFeedbackModel;
use App\Src\FqUser\Infra\Eloquent\FqUserModel;


class FqUserFeedbackRepository extends Repository implements FqUserFeedbackInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  FqUserFeedbackEntity $fq_user_feedback_entity
     */
    protected function store($fq_user_feedback_entity)
    {
        if ($fq_user_feedback_entity->isStored()) {
            $model = FqUserFeedbackModel::find($fq_user_feedback_entity->id);
        } else {
            $model = new FqUserFeedbackModel();
        }
        $model->fill(
            [
                'fq_user_id' => $fq_user_feedback_entity->fq_user_id,
                'image_id'   => $fq_user_feedback_entity->image_id,
                'contact'    => $fq_user_feedback_entity->contact,
                'device'     => $fq_user_feedback_entity->device,
                'appver'     => $fq_user_feedback_entity->appver,
                'content'    => $fq_user_feedback_entity->content,
                'status'     => $fq_user_feedback_entity->status,
            ]
        );
        $model->save();
        $fq_user_feedback_entity->setIdentity($model->id);

    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return FqUserFeedbackEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = FqUserFeedbackModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param FqUserFeedbackModel $model
     * @return FqUserFeedbackEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new FqUserFeedbackEntity();
        $entity->id = $model->id;
        $entity->fq_user_id = $model->fq_user_id;
        $entity->image_id = $model->image_id;
        $entity->contact = $model->contact;
        $entity->device = $model->device;
        $entity->appver = $model->appver;
        $entity->content = $model->content;
        $entity->status = $model->status;

        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    public function search(FqUserFeedbackSpecification $spec, $per_page = 20)
    {
        $builder = FqUserFeedbackModel::query();
        $builder->orderByDesc('created_at');

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
     * @param int $id
     * @return mixed|void
     */
    public function delete($id)
    {
        $builder = FqUserFeedbackModel::query();
        $builder->whereIn('id', (array)$id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }
}
