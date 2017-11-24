<?php namespace App\Src\Content\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Content\Domain\Interfaces\UserAnswerInterface;
use App\Src\Content\Domain\Model\UserAnswerEntity;
use App\Src\Content\Infra\Eloquent\UserAnswerModel;

class UserAnswerRepository extends Repository implements UserAnswerInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  UserAnswerEntity $user_answer_entity
     *
     */
    protected function store($user_answer_entity)
    {
        if ($user_answer_entity->isStored()) {
            $model = UserAnswerModel::find($user_answer_entity->id);
        } else {
            $model = new UserAnswerModel();
        }
        $model->fill(
            [
                'user_id' => $user_answer_entity->user_id,
                'answer'  => $user_answer_entity->answer,
            ]
        );
        $model->save();
        $user_answer_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return UserAnswerEntity|null
     *
     */
    protected function reconstitute($id, $params = [])
    {
        $model = UserAnswerModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return UserAnswerEntity
     *
     */
    private function reconstituteFromModel($model)
    {
        $entity = new UserAnswerEntity();
        $entity->id = $model->id;
        $entity->user_id = $model->user_id;
        $entity->answer = $model->answer;
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
        $builder = UserAnswerModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }


    /**
     * @param $user_id
     * @param $time
     * @return UserAnswerEntity|null
     */
    public function getUserAnswerByUserId($user_id, $time)
    {
        $builder = UserAnswerModel::query();
        $builder->where('user_id', $user_id);
        $builder->where('updated_at','>', $time);
        $model = $builder->first();
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

}
