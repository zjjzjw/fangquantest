<?php namespace App\Src\Developer\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Developer\Domain\Interfaces\DeveloperProjectContactVisitLogInterface;
use App\Src\Developer\Domain\Model\DeveloperProjectContactVisitLogEntity;
use App\Src\Developer\Infra\Eloquent\DeveloperProjectContactVisitLogModel;

class DeveloperProjectContactVisitLogRepository extends Repository implements DeveloperProjectContactVisitLogInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  DeveloperProjectContactVisitLogEntity $developer_project_contacts_entity
     */
    protected function store($developer_project_contacts_entity)
    {
        if ($developer_project_contacts_entity->isStored()) {
            $build = DeveloperProjectContactVisitLogModel::query();
            $build->where(['user_id'              => $developer_project_contacts_entity->user_id,
                           'developer_project_id' => $developer_project_contacts_entity->developer_project_id,
            ]);
            $model = $build->get();
        } else {
            $model = new DeveloperProjectContactVisitLogModel();
        }
        $model->fill(
            [
                'user_id'              => $developer_project_contacts_entity->user_id,
                'developer_project_id' => $developer_project_contacts_entity->developer_project_id,
                'role_type'            => $developer_project_contacts_entity->role_type,
                'role_id'              => $developer_project_contacts_entity->role_id,
            ]
        );

        $model->save();
        $developer_project_contacts_entity->setIdentity($model->user_id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return DeveloperProjectContactVisitLogEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = DeveloperProjectContactVisitLogModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return DeveloperProjectContactVisitLogEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new DeveloperProjectContactVisitLogEntity();

        $entity->user_id = $model->user_id;
        $entity->developer_project_id = $model->developer_project_id;
        $entity->role_type = $model->role_type;
        $entity->role_id = $model->role_id;

        $entity->setIdentity($model->user_id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param $developer_project_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProjectContactVisitLogByProjectId($developer_project_id)
    {
        $collection = collect();
        $builder = DeveloperProjectContactVisitLogModel::query();
        $builder->where('developer_project_id', $developer_project_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }


    /**
     * 一个项目自能添加一次记录
     * @param int $developer_project_id
     * @param int $user_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProjectContractVisitLogByProjectIdAndUserId($developer_project_id, $user_id)
    {
        $collection = collect();
        $builder = DeveloperProjectContactVisitLogModel::query();
        $builder->where('developer_project_id', $developer_project_id);
        $builder->where('user_id', $user_id);
        $model = $builder->first();
        if (!isset($model)) {
            return null;
        }
        return $collection;
    }

}