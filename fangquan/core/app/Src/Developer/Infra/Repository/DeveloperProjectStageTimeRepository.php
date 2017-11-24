<?php namespace App\Src\Developer\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Developer\Domain\Interfaces\DeveloperProjectStageTimeInterface;
use App\Src\Developer\Domain\Model\DeveloperProjectStageTimeEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectStageTimeSpecification;
use App\Src\Developer\Infra\Eloquent\DeveloperProjectStageTimeModel;

class DeveloperProjectStageTimeRepository extends Repository implements DeveloperProjectStageTimeInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  DeveloperProjectStageTimeEntity $developer_project_stage_time_entity
     */
    protected function store($developer_project_stage_time_entity)
    {
        if ($developer_project_stage_time_entity->isStored()) {
            $model = DeveloperProjectStageTimeModel::find($developer_project_stage_time_entity->id);
        } else {
            $model = new DeveloperProjectStageTimeModel();
        }
        $model->fill(
            [
                'project_id' => $developer_project_stage_time_entity->project_id,
                'time'       => $developer_project_stage_time_entity->time,
                'stage_type' => $developer_project_stage_time_entity->stage_type,
            ]
        );
        $model->save();

        $developer_project_stage_time_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return DeveloperProjectStageTimeEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = DeveloperProjectStageTimeModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param DeveloperProjectStageTimeModel $model
     * @return DeveloperProjectStageTimeEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new DeveloperProjectStageTimeEntity();
        $entity->id = $model->id;
        $entity->project_id = $model->project_id;
        $entity->time = $model->time;
        $entity->stage_type = $model->stage_type;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }


    /**
     * @param DeveloperProjectStageTimeSpecification $spec
     * @param int                                    $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(DeveloperProjectStageTimeSpecification $spec, $per_page = 10)
    {
        $builder = DeveloperProjectStageTimeModel::query();

        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }

        if ($spec->project_id) {
            $builder->where('project_id', $spec->project_id);
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
     * @param $ids
     */
    public function delete($ids)
    {
        $builder = DeveloperProjectStageTimeModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @param $project_id
     * @param $stage_type
     * @return array|\Illuminate\Support\Collection
     */
    public function getDeveloperProjectStageTimeByProjectIdAndType($project_id, $stage_type)
    {
        $collection = collect();
        $builder = DeveloperProjectStageTimeModel::query();
        $builder->where('project_id', $project_id);
        $builder->whereIn('stage_type', (array)$stage_type);
        $models = $builder->get();
        /** @var DeveloperProjectStageTimeModel $model */
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }
}