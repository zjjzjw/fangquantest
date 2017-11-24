<?php namespace App\Src\Developer\Infra\Repository;

use App\Foundation\Domain\Repository;
use App\Service\Developer\DeveloperProjectService;
use App\Src\Developer\Domain\Interfaces\DeveloperProjectInterface;
use App\Src\Developer\Domain\Model\DeveloperProjectAdType;
use App\Src\Developer\Domain\Model\DeveloperProjectEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectSpecification;
use App\Src\Developer\Infra\Eloquent\DeveloperProjectCategoryModel;
use App\Src\Developer\Infra\Eloquent\DeveloperProjectHasProjectCategoryModel;
use App\Src\Developer\Infra\Eloquent\DeveloperProjectCategoryTypeModel;
use App\Src\Developer\Infra\Eloquent\DeveloperProjectModel;
use App\Src\Provider\Domain\Model\ProviderAdType;

class DeveloperProjectRepository extends Repository implements DeveloperProjectInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param  DeveloperProjectEntity $developer_project_entity
     */
    protected function store($developer_project_entity)
    {
        if ($developer_project_entity->isStored()) {
            $model = DeveloperProjectModel::find($developer_project_entity->id);
        } else {
            $model = new DeveloperProjectModel();
        }
        $model->fill(
            [
                'name'                      => $developer_project_entity->name,
                'time'                      => $developer_project_entity->time,
                'developer_id'              => $developer_project_entity->developer_id,
                'project_stage_id'          => $developer_project_entity->project_stage_id,
                'is_great'                  => $developer_project_entity->is_great,
                'developer_type'            => $developer_project_entity->developer_type,
                'province_id'               => $developer_project_entity->province_id,
                'city_id'                   => $developer_project_entity->city_id,
                'address'                   => $developer_project_entity->address,
                'cost'                      => $developer_project_entity->cost,
                'views'                     => $developer_project_entity->views,
                'type'                      => $developer_project_entity->type,
                'project_category'          => $developer_project_entity->project_category,
                'time_start'                => $developer_project_entity->time_start,
                'time_end'                  => $developer_project_entity->time_end,
                'stage_design'              => $developer_project_entity->stage_design,
                'stage_build'               => $developer_project_entity->stage_build,
                'stage_decorate'            => $developer_project_entity->stage_decorate,
                'floor_space'               => $developer_project_entity->floor_space,
                'floor_numbers'             => $developer_project_entity->floor_numbers,
                'investments'               => $developer_project_entity->investments,
                'heating_mode'              => $developer_project_entity->heating_mode,
                'wall_materials'            => $developer_project_entity->wall_materials,
                'has_decorate'              => $developer_project_entity->has_decorate,
                'has_airconditioner'        => $developer_project_entity->has_airconditioner,
                'has_steel'                 => $developer_project_entity->has_steel,
                'has_elevator'              => $developer_project_entity->has_elevator,
                'summary'                   => $developer_project_entity->summary,
                'status'                    => $developer_project_entity->status,
                'is_ad'                     => $developer_project_entity->is_ad,
                'source'                    => $developer_project_entity->source,
                'other'                     => $developer_project_entity->other,
                'area'                      => $developer_project_entity->area,
                'contacts'                  => $developer_project_entity->contacts,
                'contacts_address'          => $developer_project_entity->contacts_address,
                'contacts_email'            => $developer_project_entity->contacts_email,
                'contacts_phone'            => $developer_project_entity->contacts_phone,
                'bidding_type'              => $developer_project_entity->bidding_type,
                'deadline_for_registration' => $developer_project_entity->deadline_for_registration,
            ]
        );
        $model->save();

        /** 设计产品类别数据保存 */
        if (isset($developer_project_entity->developer_project_category)) {
            $model->product_categories()->sync($developer_project_entity->developer_project_category);
        }

        /** 项目类型数据(可多选)保存 */
        if (!empty($developer_project_entity->project_categories)) {
            $this->saveProjectCategories($model, $developer_project_entity->project_categories);
        }

        if (isset($developer_project_entity->project_category_ids)) {
            $model->developer_project_categories()->sync($developer_project_entity->project_category_ids);
        }

        $developer_project_entity->setIdentity($model->id);
    }


    /**
     * 项目类型数据保存
     * @param DeveloperProjectModel $model
     * @param                       $project_categories
     */
    protected function saveProjectCategories($model, $project_categories)
    {
        $item = [];
        $this->deleteProjectCategories($model->id);
        foreach ($project_categories as $project_category) {
            $item[] = new DeveloperProjectCategoryTypeModel([
                'project_category_id' => $project_category,
            ]);
        }
        $model->project_categories()->saveMany($item);
    }

    protected function deleteProjectCategories($id)
    {
        $developer_project_category_type_query = DeveloperProjectCategoryTypeModel::query();
        $developer_project_category_type_query->where('project_id', $id);
        $developer_project_category_type_models = $developer_project_category_type_query->get();
        foreach ($developer_project_category_type_models as $developer_project_category_type_model) {
            $developer_project_category_type_model->delete();
        }
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param       $id
     * @param array $params
     *
     * @return DeveloperProjectEntity|null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = DeveloperProjectModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param DeveloperProjectModel $model
     * @return DeveloperProjectEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new DeveloperProjectEntity();
        $entity->id = $model->id;
        $entity->name = $model->name;
        $entity->time = $model->time;
        $entity->developer_id = $model->developer_id;
        $entity->project_stage_id = $model->project_stage_id;
        $entity->is_great = $model->is_great;
        $entity->developer_type = $model->developer_type;
        $entity->province_id = $model->province_id;
        $entity->city_id = $model->city_id;
        $entity->address = $model->address;
        $entity->cost = $model->cost;
        $entity->views = $model->views;
        $entity->type = $model->type;
        $entity->project_category = $model->project_category;
        $entity->time_start = $model->time_start;
        $entity->time_end = $model->time_end;
        $entity->stage_design = $model->stage_design;
        $entity->stage_build = $model->stage_build;
        $entity->stage_decorate = $model->stage_decorate;
        $entity->floor_space = $model->floor_space;
        $entity->floor_numbers = $model->floor_numbers;
        $entity->investments = $model->investments;
        $entity->heating_mode = $model->heating_mode;
        $entity->wall_materials = $model->wall_materials;
        $entity->has_decorate = $model->has_decorate;
        $entity->has_airconditioner = $model->has_airconditioner;
        $entity->has_steel = $model->has_steel;
        $entity->has_elevator = $model->has_elevator;
        $entity->summary = $model->summary;
        $entity->status = $model->status;
        $entity->is_ad = $model->is_ad;
        $entity->source = $model->source;
        $entity->area = $model->area;
        $entity->other = $model->other;
        $entity->contacts = $model->contacts;
        $entity->contacts_phone = $model->contacts_phone;
        $entity->contacts_email = $model->contacts_email;
        $entity->contacts_address = $model->contacts_address;
        $entity->bidding_type = $model->bidding_type;
        $entity->deadline_for_registration = $model->deadline_for_registration;
        //项目类型
        $entity->project_categories = $model->project_categories->pluck('project_category_id')->toArray();
        //产品品类类型
        $entity->developer_project_category = $model->product_categories->pluck('id')->toArray();
        //项目品类类型
        $entity->project_category_ids = $model->developer_project_categories->pluck('id')->toArray();

        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }


    /**
     * @param DeveloperProjectSpecification $spec
     * @param int                           $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(DeveloperProjectSpecification $spec, $per_page = 10)
    {
        $builder = DeveloperProjectModel::query();
        if ($spec->keyword) {
            $builder->leftJoin('developer', function ($join) {
                $join->on('developer_project.developer_id', '=', 'developer.id');
            });
            $builder->where(function ($query) use ($spec) {
                $query->where('developer_project.name', 'like', '%' . $spec->keyword . '%')
                    ->orWhere('developer.name', 'like', '%' . $spec->keyword . '%');
            });
        }
        if ($spec->bidding_type) {
            $builder->where('developer_project.bidding_type', $spec->bidding_type);
        }
        if ($spec->developer_id) {
            $builder->where('developer_project.developer_id', $spec->developer_id);
        }

        if ($spec->project_stage_id) {
            $builder->where('developer_project.project_stage_id', $spec->project_stage_id);
        }

        if (!empty($spec->province_id)) {
            $builder->whereIn('developer_project.province_id', (array)$spec->province_id);
        }

        if ($spec->is_great) {
            $builder->where('developer_project.is_great', $spec->is_great);
        }

        if ($spec->developer_type) {
            $builder->where('developer_project.developer_type', $spec->developer_type);
        }

        if ($spec->project_category) {
            $builder->where('developer_project.project_category', $spec->project_category);
        }

        if ($spec->is_ad) {
            $builder->where('developer_project.is_ad', $spec->is_ad);
        }

        if ($spec->status) {
            $builder->whereIn('developer_project.status', (array)$spec->status);
        }

        if (!empty($spec->product_category_id)) {
            $builder->whereIn('developer_project.id', $this->getDeveloperProjectIdsByProductCategoryId($spec->product_category_id));
        }
        if (!empty($spec->project_category_id)) {
            $builder->whereIn('developer_project.id', $this->getDeveloperProjectIdsByProjectCategoryId($spec->project_category_id));
        }

        if ($spec->column && $spec->sort) {
            $builder->orderBy($spec->column, $spec->sort);
        } else {
            $builder->orderBy('developer_project.updated_at', 'desc');
        }

        if ($spec->user_id) {
            $builder->leftJoin('developer_project_favorite', function ($join) {
                $join->on('developer_project.id', '=', 'developer_project_favorite.developer_project_id');
                $join->whereRaw('developer_project_favorite.deleted_at is NULL');
            });
            $builder->where('developer_project_favorite.user_id', $spec->user_id);
        }

        //项目类别
        if ($spec->project_categories) {
            $builder->leftJoin('developer_project_category_type', function ($join) {
                $join->on('developer_project.id', '=', 'developer_project_category_type.project_id');
            });
            $builder->whereIn('developer_project_category_type.project_category_id', (array)$spec->project_categories);
        }

        if ($spec->bidding_type) {
            $builder->whereIn('developer_project.bidding_type', (array)$spec->bidding_type);
        }

        $builder->distinct();
        $builder->select('developer_project.*');
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
     * 得到某一产品品类下面的供应商IDS
     * @param int|array $product_category_id
     * @return array
     */
    private function getDeveloperProjectIdsByProductCategoryId($product_category_id)
    {
        $developer_project_ids = [];
        $builder = DeveloperProjectCategoryModel::query();
        $builder->whereIn('product_category_id', (array)$product_category_id);
        $developer_project_ids = $builder->get()->pluck('developer_project_id')->toArray();

        return $developer_project_ids;
    }

    /**
     * 得到某一项目品类下面的供应商IDS
     * @param int|array $product_category_id
     * @return array
     */
    private function getDeveloperProjectIdsByProjectCategoryId($project_category_id)
    {
        $developer_project_ids = [];
        $builder = DeveloperProjectHasProjectCategoryModel::query();
        $builder->where('project_category_id', $project_category_id);
        $developer_project_ids = $builder->get()->pluck('developer_project_id')->toArray();
        return $developer_project_ids;
    }

    /**
     * @param int|array $ids
     */
    public function delete($ids)
    {
        $builder = DeveloperProjectModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        /** @var DeveloperProjectModel $model */
        foreach ($models as $model) {
            $provider_main_categories = $model->product_categories->pluck('id')->toArray();
            if (!empty($provider_main_categories)) {
                $model->product_categories()->detach($provider_main_categories);
            }
            $model->delete();
        }
    }


    /**
     * @param $developer_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProjectListByDeveloperId($developer_id)
    {
        $collect = collect();
        $builder = DeveloperProjectModel::query();
        $builder->where('developer_id', $developer_id);
        $models = $builder->get();
        /** @var DeveloperProjectModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @return array
     */
    public function getDeveloperProjectIsAd()
    {
        $data = [];
        $builder = DeveloperProjectModel::query();
        $builder->where('is_ad', ProviderAdType::YES);
        $models = $builder->get();
        /** @var DeveloperProjectModel $model */
        foreach ($models as $model) {
            $data[] = $this->reconstituteFromModel($model)->stored();
        }
        return $data;
    }


    /**
     * 热门推荐前十项目
     * @param array|int $status
     * @param array|int $limit
     * @return array|\Illuminate\Support\Collection
     */
    public function getAdDeveloperProjectList($status, $limit)
    {
        $collect = collect();
        $builder = DeveloperProjectModel::query();
        $builder->where('is_ad', DeveloperProjectAdType::YES);

        if (!empty($status)) {
            $builder->whereIn('status', (array)$status);
        }
        if ($limit) {
            $builder->limit($limit);
        } else {
            $builder->limit(10);
        }
        $models = $builder->get();
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


    /**
     * @param int       $limit
     * @param int|array $status
     */
    public function getTopDeveloperProjects($limit, $status)
    {
        $collect = collect();
        $builder = DeveloperProjectModel::query();
        $builder->where('status', (array)$status);
        $builder->limit($limit);
        $builder->orderBy('created_at', 'desc');
        $models = $builder->get();
        /** @var DeveloperProjectModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @return array|\Illuminate\Support\Collection
     */
    public function all()
    {
        $collection = collect();
        $builder = DeveloperProjectModel::query();
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }

}