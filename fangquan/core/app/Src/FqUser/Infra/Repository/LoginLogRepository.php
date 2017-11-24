<?php namespace App\Src\FqUser\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\FqUser\Domain\Interfaces\LoginLogInterface;
use App\Src\FqUser\Domain\Model\LoginLogEntity;
use App\Src\FqUser\Domain\Model\LoginLogSpecification;
use App\Src\FqUser\Infra\Eloquent\LoginLogModel;

class LoginLogRepository extends Repository implements LoginLogInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  LoginLogEntity $login_log_entity
     */
    protected function store($login_log_entity)
    {
        if ($login_log_entity->isStored()) {
            $model = LoginLogModel::find($login_log_entity->id);
        } else {
            $model = new LoginLogModel();
        }
        $model->fill(
            [
                'user_id' => $login_log_entity->user_id,
                'type'    => $login_log_entity->type,
                'ip'      => $login_log_entity->ip,
            ]
        );
        $model->save();
        $login_log_entity->setIdentity($model->id);
    }


    public function search(LoginLogSpecification $spec, $per_page = 20)
    {
        $builder = LoginLogModel::query();
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


    public function getLoginLogByUserId($user_id)
    {
        $builder = LoginLogModel::query();
        $builder->where('user_id', $user_id);
        $model = $builder->first();
        if (isset($model)) {
            return $this->reconstituteFromModel($model)->stored();
        } else {
            return null;
        }
    }


    /**
     * @param $id
     * @return mixed|void
     */
    public function delete($id)
    {
        $builder = LoginLogModel::query();
        $builder->whereIn('id', (array)$id);
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
     * @return LoginLogEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = LoginLogModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param LoginLogModel $model
     * @return LoginLogEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new LoginLogEntity();
        $entity->id = $model->id;
        $entity->user_id = $model->user_id;
        $entity->type = $model->type;
        $entity->ip = $model->ip;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }
}
