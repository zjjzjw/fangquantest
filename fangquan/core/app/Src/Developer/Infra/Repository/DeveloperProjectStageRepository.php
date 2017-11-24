<?php namespace App\Src\Developer\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Developer\Domain\Interfaces\DeveloperProjectStageInterface;
use App\Src\Developer\Domain\Model\DeveloperProjectStageEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectStageSpecification;
use App\Src\Developer\Infra\Eloquent\DeveloperProjectStageModel;

class DeveloperProjectStageRepository extends Repository implements DeveloperProjectStageInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  DeveloperProjectStageEntity $developer_project_stage_entity
     */
    protected function store($developer_project_stage_entity)
    {
        if ($developer_project_stage_entity->isStored()) {
            $model = DeveloperProjectStageModel::find($developer_project_stage_entity->id);
        } else {
            $model = new DeveloperProjectStageModel();
        }
        $model->fill(
            [
                'name' => $developer_project_stage_entity->name,
                'sort' => $developer_project_stage_entity->sort,
            ]
        );
        $model->save();
        $developer_project_stage_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return DeveloperProjectStageEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = DeveloperProjectStageModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return DeveloperProjectStageEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new DeveloperProjectStageEntity();
        $entity->id = $model->id;
        $entity->name = $model->name;
        $entity->sort = $model->sort;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }


    /**
     * @param DeveloperProjectStageSpecification $spec
     * @param int                                $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(DeveloperProjectStageSpecification $spec, $per_page = 10)
    {
        $builder = DeveloperProjectStageModel::query();

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
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        $collection = collect();
        $builder = DeveloperProjectStageModel::query();
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }
}