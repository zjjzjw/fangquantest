<?php namespace App\Src\Provider\Infra\Repository;


use App\Foundation\Domain\Repository;
use App\Src\Product\Infra\Eloquent\ProductAttributeValueModel;
use App\Src\Product\Infra\Repository\ProductCategoryRepository;
use App\Src\Provider\Domain\Interfaces\ProviderInterface;
use App\Src\Provider\Domain\Model\ProviderAdType;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderSpecification;
use App\Src\Provider\Infra\Eloquent\BrandFriendModel;
use App\Src\Provider\Infra\Eloquent\ProviderDomesticImportModel;
use App\Src\Provider\Infra\Eloquent\ProviderMainCategoryModel;
use App\Src\Provider\Infra\Eloquent\ProviderManagementModeModel;
use App\Src\Provider\Infra\Eloquent\ProviderModel;
use App\Src\Provider\Infra\Eloquent\ProviderPictureModel;
use Illuminate\Support\Facades\DB;

class ProviderRepository extends Repository implements ProviderInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ProviderEntity $provider_entity
     */
    protected function store($provider_entity)
    {
        if ($provider_entity->isStored()) {
            $model = ProviderModel::find($provider_entity->id);
        } else {
            $model = new ProviderModel();
        }
        $model->fill(
            [
                'company_name'            => $provider_entity->company_name,
                'brand_name'              => $provider_entity->brand_name,
                'patent_count'            => $provider_entity->patent_count,
                'favorite_count'          => $provider_entity->favorite_count,
                'product_count'           => $provider_entity->product_count,
                'project_count'           => $provider_entity->project_count,
                'province_id'             => $provider_entity->province_id,
                'city_id'                 => $provider_entity->city_id,
                'operation_address'       => $provider_entity->operation_address,
                'produce_province_id'     => $provider_entity->produce_province_id,
                'produce_city_id'         => $provider_entity->produce_city_id,
                'produce_address'         => $provider_entity->produce_address,
                'telphone'                => $provider_entity->telphone,
                'fax'                     => $provider_entity->fax,
                'service_telphone'        => $provider_entity->service_telphone,
                'website'                 => $provider_entity->website,
                'operation_mode'          => $provider_entity->operation_mode,
                'founding_time'           => $provider_entity->founding_time,
                'turnover'                => $provider_entity->turnover,
                'registered_capital'      => $provider_entity->registered_capital,
                'registered_capital_unit' => $provider_entity->registered_capital_unit,
                'worker_count'            => $provider_entity->worker_count,
                'summary'                 => $provider_entity->summary,
                'corp'                    => $provider_entity->corp,
                'score_scale'             => $provider_entity->score_scale,
                'score_qualification'     => $provider_entity->score_qualification,
                'score_credit'            => $provider_entity->score_credit,
                'score_innovation'        => $provider_entity->score_innovation,
                'score_service'           => $provider_entity->score_service,
                'contact'                 => $provider_entity->contact,
                'rank'                    => $provider_entity->rank,
                'integrity'               => $provider_entity->integrity,
                'is_ad'                   => $provider_entity->is_ad,
                'status'                  => $provider_entity->status,
                'corp_phone'              => $provider_entity->corp_phone,
                'company_type'            => $provider_entity->company_type,
            ]
        );
        $model->save();
        $this->saveProviderPictureAndMainCategory($model, $provider_entity);
        if (!empty($provider_entity->provider_domestic_imports)) {
            $this->saveDomesticImports($model, $provider_entity->provider_domestic_imports);
        }
        if (!empty($provider_entity->provider_management_modes)) {
            $this->saveManagementModes($model, $provider_entity->provider_management_modes);
        }
        if (!empty($provider_entity->brand_friends)) {
            $this->saveFriends($model, $provider_entity->brand_friends);
        }
        $provider_entity->setIdentity($model->id);
    }

    /**
     * @param ProviderModel $model
     * @param               $friends
     */
    protected function saveFriends($model, $friends)
    {
        $item = [];
        $this->deleteFriends($model->id);
        foreach ($friends as $friend) {
            $item[] = new BrandFriendModel([
                'brand_friend_id' => $friend,
            ]);
        }
        $model->brand_friends()->saveMany($item);
    }

    protected function deleteFriends($id)
    {
        $brand_friend_query = BrandFriendModel::query();
        $brand_friend_query->where('brand_id', $id);
        $brand_friend_models = $brand_friend_query->get();
        foreach ($brand_friend_models as $brand_friend_model) {
            $brand_friend_model->delete();
        }
    }

    /**
     * @param ProviderModel $model
     * @param               $provider_domestic_imports
     */
    protected function saveDomesticImports($model, $provider_domestic_imports)
    {
        $item = [];
        $this->deleteDomesticImports($model->id);
        foreach ($provider_domestic_imports as $provider_domestic_import) {
            $item[] = new ProviderDomesticImportModel([
                'domestic_import_id' => $provider_domestic_import,
            ]);
        }
        $model->provider_domestic_imports()->saveMany($item);
    }

    protected function deleteDomesticImports($id)
    {
        $provider_domestic_import_query = ProviderDomesticImportModel::query();
        $provider_domestic_import_query->where('provider_id', $id);
        $provider_domestic_import_models = $provider_domestic_import_query->get();
        foreach ($provider_domestic_import_models as $provider_domestic_import_model) {
            $provider_domestic_import_model->delete();
        }
    }


    /**
     * @param ProviderModel $model
     * @param array         $provider_management_mode_types
     */
    protected function saveManagementModes($model, $provider_management_mode_types)
    {
        $items = [];
        $this->deleteManagementModes($model->id);
        foreach ($provider_management_mode_types as $provider_management_mode_type) {
            $item = new ProviderManagementModeModel([
                'management_mode_type' => $provider_management_mode_type,
            ]);
            $items[] = $item;
        }
        $model->provider_management_modes()->saveMany($items);
    }

    protected function deleteManagementModes($id)
    {
        $provider_domestic_import_query = ProviderManagementModeModel::query();
        $provider_domestic_import_query->where('provider_id', $id);
        $provider_domestic_import_models = $provider_domestic_import_query->get();
        foreach ($provider_domestic_import_models as $provider_domestic_import_model) {
            $provider_domestic_import_model->delete();
        }
    }

    /**
     * @param ProviderModel  $model
     * @param ProviderEntity $provider_entity
     */
    public function saveProviderPictureAndMainCategory($model, $provider_entity)
    {
        if (!empty($provider_entity->provider_pictures)) {
            $provider_picture_query = ProviderPictureModel::query();
            $provider_picture_query->where('provider_id', $model->id);
            $provider_picture_models = $provider_picture_query->get();
            foreach ($provider_picture_models as $provider_picture_model) {
                $provider_picture_model->delete();
            }
            $provider_pictures = [];
            foreach ($provider_entity->provider_pictures as $provider_picture) {
                $provider_picture['provider_id'] = $model->id;
                $provider_pictures[] = $provider_picture;
            }
            $model->provider_pictures()->createMany($provider_pictures);
        }

        if (!empty($provider_entity->provider_main_category)) {
            $provider_main_category_query = ProviderMainCategoryModel::query();
            $provider_main_category_query->where('provider_id', $model->id);
            $provider_main_category_models = $provider_main_category_query->get();
            foreach ($provider_main_category_models as $provider_main_category_model) {
                $provider_main_category_model->delete();
            }
            $main_categories = [];
            foreach ($provider_entity->provider_main_category as $value) {
                $main_category['provider_id'] = $model->id;
                $main_category['product_category_id'] = $value;
                $main_categories[] = $main_category;
            }
            $model->provider_main_categories()->createMany($main_categories);
        }
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return ProviderEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProviderModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProviderModel $model
     *
     * @return ProviderEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProviderEntity();

        $entity->id = $model->id;
        $entity->company_name = $model->company_name;
        $entity->brand_name = $model->brand_name;
        $entity->patent_count = $model->patent_count;
        $entity->favorite_count = $model->favorite_count;
        $entity->product_count = $model->product_count;
        $entity->project_count = $model->project_count;
        $entity->province_id = $model->province_id;
        $entity->city_id = $model->city_id;
        $entity->operation_address = $model->operation_address;
        $entity->produce_province_id = $model->produce_province_id;
        $entity->produce_city_id = $model->produce_city_id;
        $entity->produce_address = $model->produce_address;
        $entity->telphone = $model->telphone;
        $entity->fax = $model->fax;
        $entity->service_telphone = $model->service_telphone;
        $entity->website = $model->website;
        $entity->operation_mode = $model->operation_mode;
        $entity->founding_time = $model->founding_time;
        $entity->turnover = $model->turnover;
        $entity->registered_capital = $model->registered_capital;
        $entity->registered_capital_unit = $model->registered_capital_unit;
        $entity->worker_count = $model->worker_count;
        $entity->summary = $model->summary;
        $entity->corp = $model->corp;
        $entity->score_scale = $model->score_scale;
        $entity->score_qualification = $model->score_qualification;
        $entity->score_credit = $model->score_credit;
        $entity->score_innovation = $model->score_innovation;
        $entity->score_service = $model->score_service;
        $entity->contact = $model->contact;
        $entity->integrity = $model->integrity;
        $entity->is_ad = $model->is_ad;
        $entity->rank = $model->rank;
        $entity->status = $model->status;
        $entity->rank = $model->rank;
        $entity->provider_pictures = $model->provider_pictures;
        $entity->provider_main_category = $model->provider_main_category;
        $entity->provider_domestic_imports = $model->provider_domestic_imports->pluck('domestic_import_id')->toArray();
        $entity->company_type = $model->company_type;
        $entity->corp_phone = $model->corp_phone;
        $entity->provider_management_modes = $model->provider_management_modes->pluck('management_mode_type')->toArray();
        $entity->brand_friends = $model->brand_friends->pluck('brand_friend_id')->toArray();
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();

        return $entity;
    }

    /**
     * @param ProviderSpecification $spec
     * @param int                   $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ProviderSpecification $spec, $per_page = 10)
    {
        $builder = ProviderModel::query();

        if ($spec->provider_id) {
            $builder->where('provider.id', $spec->provider_id);
        }
        if ($spec->project_case_count_start) {
            $builder->where('provider.project_count', '>=', $spec->project_case_count_start);
        }
        if ($spec->project_case_count_end) {
            $builder->where('provider.project_count', '<=', $spec->project_case_count_end);
        }
        if ($spec->operation_mode) {
            $builder->where('provider.operation_mode', $spec->operation_mode);
        }
        if ($spec->registered_capital_start) {
            $builder->where('provider.registered_capital', '>=', $spec->registered_capital_start);
        }
        if ($spec->registered_capital_end) {
            $builder->where('provider.registered_capital', '<', $spec->registered_capital_end);
        }
        if ($spec->province_id) {
            $builder->whereIn('provider.province_id', (array)$spec->province_id);
        }
        if ($spec->city_id) {
            $builder->whereIn('provider.city_id', (array)$spec->city_id);
        }
        if ($spec->status) {
            $builder->where('provider.status', $spec->status);
        }
        if ($spec->product_category_id) {
            $builder->whereIn('provider.id', $this->getProviderIdsByProductCategoryId($spec->product_category_id));
        }
        /*if ($spec->keyword) {
            $builder->where(function ($query) use ($spec) {
                $query->where('provider.brand_name', 'like', '%' . $spec->keyword . '%')
                    ->orWhere('provider.company_name', 'like', '%' . $spec->keyword . '%');
            });
        }*/
        if ($spec->column && $spec->sort) {
            $builder->orderBy($spec->column, $spec->sort);
        } else {
            $builder->orderBy('provider.created_at', 'asc');
        }

        if ($spec->user_id) {
            $builder->leftJoin('provider_favorite', function ($join) {
                $join->on('provider.id', '=', 'provider_favorite.provider_id');
                $join->whereRaw('provider_favorite.deleted_at is NULL');
            });
            $builder->where('provider_favorite.user_id', $spec->user_id);
        }

        if ($spec->company_type) {
            $builder->where('provider.company_type', $spec->company_type);
        }

        if ($spec->product_type) {
            $builder->leftJoin('provider_domestic_import', function ($join) use ($spec) {
                $join->on('provider.id', '=', 'provider_domestic_import.provider_id');
            });
            $builder->where('provider_domestic_import.domestic_import_id', $spec->product_type);
        }

        if (($spec->attributes || $spec->category_id) || $spec->keyword) {

            $builder->leftJoin('product', function ($join) use ($spec) {
                $join->on('provider.id', '=', 'product.brand_id');
            });

            if ($spec->attributes || $spec->category_id) {
                foreach ($spec->attributes as $key => $value) {
                    $builder->whereIn('product.id', $this->getProductIdByAttribute($key, array_values($value)));
                }
                if ($spec->category_id) {
                    $builder->where('product.product_category_id', $spec->category_id);
                }
            }
            if ($spec->keyword) {

                $builder->leftJoin('provider_main_category', function ($join) use ($spec) {
                    $join->on('provider.id', '=', 'provider_main_category.provider_id');
                });
                $builder->leftJoin('category', function ($join) use ($spec) {
                    $join->on('category.id', '=', 'provider_main_category.product_category_id');
                });

                $builder->where(function ($join) use ($spec) {
                    $join->where('category.name', 'like', '%' . $spec->keyword . '%')
                        ->orWhere('provider.brand_name', 'like', '%' . $spec->keyword . '%')
                        ->orWhere('provider.company_name', 'like', '%' . $spec->keyword . '%')
                        ->orWhere('product.product_model', 'like', '%' . $spec->keyword . '%');
                });
            }
        }
        $builder->select('provider.*');
        $builder->distinct();
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

    public function getProductIdByAttribute($attribute_id, $attribute_value_id)
    {
        $builder = ProductAttributeValueModel::query();
        $builder->whereIn('attribute_id', (array)$attribute_id);
        $builder->whereIn('value_id', (array)$attribute_value_id);
        return $builder->get()->pluck('product_id')->toArray();
    }

    /**
     * @param int $product_category_id
     * @return array
     */
    protected function getProviderIdsByProductCategoryId($product_category_id)
    {
        $builder = ProviderMainCategoryModel::query();
        $builder->where('product_category_id', $product_category_id);
        $provider_main_categories = $builder->get();
        $provider_ids = $provider_main_categories->pluck('provider_id')->toArray();
        return $provider_ids;
    }


    /**
     * @param int|array $id
     */
    public function delete($id)
    {
        $builder = ProviderModel::query();
        $builder->whereIn('id', (array)$id);
        $models = $builder->get();
        foreach ($models as $model) {
            $domestic_imports = $model->provider_domestic_imports->pluck('id')->toArray();
            if (!empty($domestic_imports)) {
                $this->deleteDomesticImports($model->id);
            }

            $management_modes = $model->provider_management_modes->pluck('id')->toArray();
            if (!empty($management_modes)) {
                $this->deleteManagementModes($model->id);
            }

            $brand_friends = $model->brand_friends->pluck('id')->toArray();
            if (!empty($brand_friends)) {
                $this->deleteFriends($model->id);
            }
            $model->delete();
        }
    }


    /**
     * @param int|array $ids
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderByIds($ids, $statuses = null)
    {
        $collect = collect();
        $builder = ProviderModel::query();
        $builder->whereIn('id', (array)$ids);
        if (!empty($statuses)) {
            $builder->whereIn('status', $statuses);
        }
        $builder->orderByRaw('FIELD(id,' . implode(',', $ids) . ')');
        $models = $builder->get();
        /** @var ProviderModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param ProviderSpecification $spec
     * @param int                   $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getProviderByCategory(ProviderSpecification $spec, $per_page = 10)
    {
        $builder = ProviderModel::query();
        if ($spec->provider_id) {
            $builder->whereIn('id', (array)$spec->provider_id);
            $builder->orderByRaw(DB::raw('FIELD(id, ' . implode(',', $spec->provider_id) . ')'));
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
     * @return array
     */
    public function getProviderIsAd()
    {
        $data = [];
        $builder = ProviderModel::query();
        $builder->where('is_ad', ProviderAdType::YES);
        $builder->orderby('rank', 'asc');
        $models = $builder->get();
        /** @var ProviderModel $model */
        foreach ($models as $model) {
            $data[] = $this->reconstituteFromModel($model)->stored();
        }
        return $data;
    }

    /**
     * @param int $category_id
     * @param int $limit
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderBrandRank($category_id, $limit = 10)
    {
        $collect = collect();
        $builder = ProviderModel::query();
        $builder->leftJoin('provider_main_category', function ($join) {
            $join->on('provider_main_category.provider_id', '=', 'provider.id');
        });
        $builder->where('provider_main_category.product_category_id', $category_id);
        $builder->select('provider.*');
        $builder->distinct();
        $builder->limit($limit);

        $builder->orderBy('rank', 'desc');
        $models = $builder->get();
        /** @var ProviderModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


    public function getProviderByKeyword($keyword)
    {
        $collect = collect();
        $builder = ProviderModel::query();
        $builder->where(function ($query) use ($keyword) {
            $query->where('provider.brand_name', 'like', '%' . $keyword . '%')
                ->orWhere('provider.company_name', 'like', '%' . $keyword . '%');
        });
        $builder->limit(10);
        $models = $builder->get();
        /** @var ProviderModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }


    /**
     * @param $rank
     * @param $status
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderByRankAndStatus($rank, $status)
    {
        $collection = collect();
        $builder = ProviderModel::query();
        $builder->where('rank', $rank);
        $builder->where('status', $status);
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }

    public function getProviderMoreList($skip, $limit)
    {
        $collection = collect();
        $builder = ProviderModel::query();
        if ($skip) {
            $builder->skip($skip);
        }
        if ($limit) {
            $builder->limit($limit);
        }
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }


    /**
     * 得到广告供应商
     * @param  int|array $status
     * @param  int       $limit
     * @return array|\Illuminate\Support\Collection
     */
    public function getAdProviderList($status, $limit)
    {
        $collection = collect();
        $builder = ProviderModel::query();
        $builder->where('is_ad', ProviderAdType::YES);
        $builder->whereIn('status', (array)$status);
        if ($limit) {
            $builder->limit($limit);
        } else {
            $builder->limit(10);
        }
        $builder->orderBy('rank', 'asc');
        $models = $builder->get();
        /** @var ProviderModel $model */
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }

    /**
     * @param $company_name
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderByCompanyName($company_name)
    {
        $builder = ProviderModel::query();
        $builder->where('company_name', $company_name);
        $model = $builder->first();
        /** @var ProviderModel $model */
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @return int 得到供应商数量
     */
    public function getProviderCount()
    {
        $builder = ProviderModel::query();
        return $builder->count();
    }

}