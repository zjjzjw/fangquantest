<?php namespace App\Src\Developer\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Developer\Domain\Interfaces\DeveloperProjectFavoriteInterface;
use App\Src\Developer\Domain\Model\DeveloperProjectFavoriteEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectFavoriteSpecification;
use App\Src\Developer\Domain\Model\DeveloperProjectFavoritetSpecification;
use App\Src\Developer\Infra\Eloquent\DeveloperProjectFavoriteModel;

class DeveloperProjectFavoriteRepository extends Repository implements DeveloperProjectFavoriteInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  DeveloperProjectFavoriteEntity $developer_project_favorite_entity
     */
    protected function store($developer_project_favorite_entity)
    {
        if ($developer_project_favorite_entity->isStored()) {
            $model = DeveloperProjectFavoriteModel::find($developer_project_favorite_entity->id);
        } else {
            $model = new DeveloperProjectFavoriteModel();
        }
        $model->fill(
            [
                'user_id'              => $developer_project_favorite_entity->user_id,
                'developer_project_id' => $developer_project_favorite_entity->developer_project_id,
            ]
        );
        $model->save();
        $developer_project_favorite_entity->setIdentity($model->id);
    }

    /**
     * @param DeveloperProjectFavoriteSpecification $spec
     * @param int                                   $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(DeveloperProjectFavoriteSpecification $spec, $per_page = 10)
    {
        $builder = DeveloperProjectFavoriteModel::query();

        if ($spec->user_id) {
            $builder->where('user_id', $spec->user_id);
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
     * @param       $id
     * @param array $params
     *
     * @return DeveloperProjectFavoriteEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = DeveloperProjectFavoriteModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return DeveloperProjectFavoriteEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new DeveloperProjectFavoriteEntity();
        $entity->id = $model->id;
        $entity->developer_project_id = $model->developer_project_id;
        $entity->user_id = $model->user_id;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param int       $user_id
     * @param int|array $developer_project_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getFavoriteByUserIdAndProjectId($user_id, $developer_project_id)
    {
        $collect = collect();
        $builder = DeveloperProjectFavoriteModel::query();
        $builder->where('user_id', $user_id);
        $builder->whereIn('developer_project_id', (array)$developer_project_id);
        $models = $builder->get();
        /** @var DeveloperProjectFavoriteModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param $ids
     */
    public function delete($ids)
    {
        $builder = DeveloperProjectFavoriteModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @param int|array $user_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getFavoriteRecordByUserId($user_id)
    {
        $collect = collect();
        $builder = DeveloperProjectFavoriteModel::query();
        $builder->where('user_id', $user_id);
        $models = $builder->get();
        /** @var DeveloperProjectFavoriteModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }
}