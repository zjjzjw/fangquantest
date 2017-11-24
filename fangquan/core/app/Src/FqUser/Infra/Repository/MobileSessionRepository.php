<?php namespace App\Src\FqUser\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\FqUser\Domain\Interfaces\MobileSessionInterface;
use App\Src\FqUser\Domain\Model\MobileSessionEntity;
use App\Src\FqUser\Domain\Model\MobileSessionSpecification;
use App\Src\FqUser\Infra\Eloquent\MobileSessionModel;

class MobileSessionRepository extends Repository implements MobileSessionInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  MobileSessionEntity $mobile_session_entity
     */
    protected function store($mobile_session_entity)
    {
        if ($mobile_session_entity->isStored()) {
            $model = MobileSessionModel::find($mobile_session_entity->id);
        } else {
            $model = new MobileSessionModel();
        }
        $model->fill(
            [
                'user_id'       => $mobile_session_entity->user_id,
                'token'         => $mobile_session_entity->token,
                'type'          => $mobile_session_entity->type,
                'reg_id'        => $mobile_session_entity->reg_id,
                'enable_notify' => $mobile_session_entity->enable_notify,
            ]
        );
        $model->save();
        $mobile_session_entity->setIdentity($model->id);
    }


    public function search(MobileSessionSpecification $spec, $per_page = 20)
    {
        $builder = MobileSessionModel::query();
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


    public function getMobileSessionByUserId($user_id)
    {
        $builder = MobileSessionModel::query();
        $builder->where('user_id', $user_id);
        $model = $builder->first();
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }


    public function tokenValid($token, $user_id = null)
    {
        $builder = MobileSessionModel::query();
        if (isset($user_id)) {
            $builder->where('user_id', $user_id);
        }
        $builder->where('token', $token);
        $model = $builder->first();
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }


    /**
     * @param $id
     * @return mixed|void
     */
    public function delete($id)
    {
        $builder = MobileSessionModel::query();
        $builder->whereIn('id', (array)$id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @param $reg_id
     * @param $user_id
     */
    public function deleteRedId($reg_id, $user_id)
    {
        $builder = MobileSessionModel::query();
        $builder->where('reg_id', $reg_id);
        $builder->where('user_id', '<>', $user_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }


    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return MobileSessionEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = MobileSessionModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param MobileSessionModel $model
     * @return MobileSessionEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new MobileSessionEntity();
        $entity->id = $model->id;
        $entity->user_id = $model->user_id;
        $entity->token = $model->token;
        $entity->reg_id = $model->reg_id;
        $entity->type = $model->type;
        $entity->enable_notify = $model->enable_notify;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }
}
