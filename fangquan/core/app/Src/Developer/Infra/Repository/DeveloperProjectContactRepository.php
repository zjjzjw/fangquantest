<?php namespace App\Src\Developer\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Src\Developer\Domain\Interfaces\DeveloperProjectContactInterface;
use App\Src\Developer\Domain\Model\DeveloperProjectContactEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectContactSpecification;
use App\Src\Developer\Infra\Eloquent\DeveloperProjectContactModel;

class DeveloperProjectContactRepository extends Repository implements DeveloperProjectContactInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  DeveloperProjectContactEntity $developer_project_contacts_entity
     */
    protected function store($developer_project_contacts_entity)
    {
        if ($developer_project_contacts_entity->isStored()) {
            $model = DeveloperProjectContactModel::find($developer_project_contacts_entity->id);
        } else {
            $model = new DeveloperProjectContactModel();
        }
        $model->fill(
            [
                'developer_project_id' => $developer_project_contacts_entity->developer_project_id,
                'type'                 => $developer_project_contacts_entity->type,
                'sort'                 => $developer_project_contacts_entity->sort,
                'company_name'         => $developer_project_contacts_entity->company_name,
                'contact_name'         => $developer_project_contacts_entity->contact_name,
                'job'                  => $developer_project_contacts_entity->job,
                'address'              => $developer_project_contacts_entity->address,
                'telphone'             => $developer_project_contacts_entity->telphone,
                'mobile'               => $developer_project_contacts_entity->mobile,
                'remark'               => $developer_project_contacts_entity->remark,
            ]
        );
        $model->save();
        $developer_project_contacts_entity->setIdentity($model->id);
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return DeveloperProjectContactEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = DeveloperProjectContactModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param $model
     * @return DeveloperProjectContactEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new DeveloperProjectContactEntity();
        $entity->id = $model->id;
        $entity->developer_project_id = $model->developer_project_id;
        $entity->type = $model->type;
        $entity->sort = $model->sort;
        $entity->company_name = $model->company_name;
        $entity->contact_name = $model->contact_name;
        $entity->job = $model->job;
        $entity->address = $model->address;
        $entity->telphone = $model->telphone;
        $entity->mobile = $model->mobile;
        $entity->remark = $model->remark;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }


    /**
     * @param DeveloperProjectContactSpecification $spec
     * @param int                                  $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(DeveloperProjectContactSpecification $spec, $per_page = 10)
    {
        $builder = DeveloperProjectContactModel::query();

        if ($spec->keyword) {
            $builder->where('name', 'like', '%' . $spec->keyword . '%');
        }

        if ($spec->developer_project_id) {
            $builder->where('developer_project_id', $spec->developer_project_id);
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
        $builder = DeveloperProjectContactModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @param $developer_project_id
     */
    public function deleteByDeveloperProjectId($developer_project_id)
    {
        $builder = DeveloperProjectContactModel::query();
        $builder->where('developer_project_id', $developer_project_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @param $developer_project_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getDeveloperProjectContactListByProjectId($developer_project_id)
    {
        $collection = collect();
        $builder = DeveloperProjectContactModel::query();
        $builder->where('developer_project_id', $developer_project_id);
        $builder->orderByDesc('sort');
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }
}