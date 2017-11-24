<?php namespace App\Src\Loupan\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Loupan\Domain\Interfaces\LoupanInterface;
use App\Src\Loupan\Domain\Model\LoupanEntity;
use App\Src\Loupan\Domain\Model\LoupanSpecification;
use App\Src\Loupan\Infra\Eloquent\LoupanModel;

class LoupanRepository extends Repository implements LoupanInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  LoupanEntity $loupan_entity
     */
    protected function store($loupan_entity)
    {
        if ($loupan_entity->isStored()) {
            $model = LoupanModel::find($loupan_entity->id);
        } else {
            $model = new LoupanModel();
        }
        $model->fill(
            [
                'name'         => $loupan_entity->name,
                'province_id'  => $loupan_entity->province_id,
                'city_id'      => $loupan_entity->city_id,
            ]
        );
        $model->save();
        if (!empty($loupan_entity->loupan_developers)) {
            $model->loupan_developers()->sync($loupan_entity->loupan_developers);
        }
        $loupan_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return LoupanEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = LoupanModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return LoupanEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new LoupanEntity();
        $entity->id = $model->id;
        $entity->name = $model->name;
        $entity->province_id = $model->province_id;
        $entity->city_id = $model->city_id;
        $entity->loupan_developers = $model->loupan_developers()->pluck('developer_id')->toArray();
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param LoupanSpecification $spec
     * @param int                 $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(LoupanSpecification $spec, $per_page = 10)
    {
        $builder = LoupanModel::query();
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
     * @param int|array $ids
     */
    public function delete($ids)
    {
        $builder = LoupanModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $loupan_developers = $model->loupan_developers()->pluck('developer_id')->toArray();
            if (!empty($loupan_developers)) {
                $model->loupan_developers()->detach($loupan_developers);
            }
            $model->delete();
        }
    }


    /**
     * @param int|array $status
     * @return array|\Illuminate\Support\Collection
     */
    public function getAllLoupanList($status)
    {
        $collect = collect();
        $builder = LoupanModel::query();
        $models = $builder->get();
        /** @var LoupanModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param int|array $name
     * @return array|\Illuminate\Support\Collection
     */
    public function getLoupanListByName($name)
    {
        $collect = collect();
        $builder = LoupanModel::query();
        $builder->where('name', $name);
        $models = $builder->get();
        /** @var LoupanModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param $keyword
     * @return array|\Illuminate\Support\Collection
     */
    public function getLoupanByKeyword($keyword)
    {
        $collect = collect();
        $builder = LoupanModel::query();
        $builder->where('name', 'like', '%' . $keyword . '%');
        $builder->limit(10);
        $models = $builder->get();
        /** @var LoupanModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }
}