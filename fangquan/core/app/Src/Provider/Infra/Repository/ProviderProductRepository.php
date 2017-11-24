<?php namespace App\Src\Provider\Infra\Repository;


use App\Foundation\Domain\Repository;
use App\Src\Product\Domain\Model\ProductCategoryStatus;
use App\Src\Product\Infra\Eloquent\ProductCategoryModel;
use App\Src\Provider\Domain\Model\ProviderProductEntity;
use App\Src\Provider\Domain\Model\ProviderProductSpecification;
use App\Src\Provider\Infra\Eloquent\ProviderMainCategoryModel;
use App\Src\Provider\Infra\Eloquent\ProviderProductModel;
use App\Src\Provider\Domain\Interfaces\ProviderProductInterface;
use App\Src\Provider\Infra\Eloquent\ProviderProductPictureModel;

class ProviderProductRepository extends Repository implements ProviderProductInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ProviderProductEntity $provider_product_entity
     */
    protected function store($provider_product_entity)
    {
        if ($provider_product_entity->isStored()) {
            $model = ProviderProductModel::find($provider_product_entity->id);
        } else {
            $model = new ProviderProductModel();
        }
        $model->fill(
            [
                'provider_id'         => $provider_product_entity->provider_id,
                'name'                => $provider_product_entity->name,
                'product_category_id' => $provider_product_entity->product_category_id,
                'views'               => $provider_product_entity->views,
                'attrib'              => $provider_product_entity->attrib,
                'attrib_integrity'    => $provider_product_entity->attrib_integrity,
                'price_low'           => $provider_product_entity->price_low,
                'price_high'          => $provider_product_entity->price_high,
                'status'              => $provider_product_entity->status,
            ]
        );
        $model->save();
        $this->saveProviderProductPicture($model, $provider_product_entity);

        $provider_product_entity->setIdentity($model->id);
    }

    /**
     * @param ProviderProductModel  $model
     * @param ProviderProductEntity $provider_product_entity
     */
    public function saveProviderProductPicture($model, $provider_product_entity)
    {
        $this->deleteProductPictureById($model->getKey());

        if (isset($provider_product_entity->provider_product_images)) {
            foreach ($provider_product_entity->provider_product_images as $image_id) {
                $provider_product_picture_model = new ProviderProductPictureModel();
                $provider_product_picture_model->provider_product_id = $model->getKey();
                $provider_product_picture_model->image_id = $image_id;
                $provider_product_picture_model->save();
            }
        }
    }

    public function deleteProductPictureById($provider_product_id)
    {
        $builder = ProviderProductPictureModel::query();
        $builder->where('provider_product_id', (array)$provider_product_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return ProviderProductEntity
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProviderProductModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProviderProductModel $model
     *
     * @return ProviderProductEntity
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProviderProductEntity();

        $entity->id = $model->id;

        $entity->provider_id = $model->provider_id;
        $entity->product_category_id = $model->product_category_id;
        $entity->name = $model->name;
        $entity->views = $model->views;
        $entity->attrib = $model->attrib;
        $entity->attrib_integrity = $model->attrib_integrity;
        $entity->price_low = $model->price_low;
        $entity->price_high = $model->price_high;
        $entity->status = $model->status;
        $entity->provider_product_images = $model->provider_product_pictures->pluck('image_id')->toArray();
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;

        $entity->setIdentity($model->id);
        $entity->stored();

        return $entity;
    }

    /**
     * @param ProviderProductSpecification $spec
     * @param int                          $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ProviderProductSpecification $spec, $per_page = 10)
    {
        $builder = ProviderProductModel::query();

        if ($spec->provider_id) {
            $builder->where('provider_product.provider_id', $spec->provider_id);
        }
        if ($spec->column && $spec->sort) {
            $builder->orderBy($spec->column, $spec->sort);
        } else {
            $builder->orderBy('provider_product.created_at', 'asc');
        }
        if ($spec->status) {
            $builder->where('provider_product.status', $spec->status);
        }
        if ($spec->second_product_category_id) {
            $builder->where('provider_product.product_category_id', $spec->second_product_category_id);
        }
        if ($spec->keyword) {
            $builder->where('provider_product.name', 'like', '%' . $spec->keyword . '%');
        }
        if ($spec->user_id) {
            $builder->leftJoin('provider_product_favorite', function ($join) {
                $join->on('provider_product.id', '=', 'provider_product_favorite.provider_product_id');
                $join->whereRaw('provider_product_favorite.deleted_at is NULL');
            });
            $builder->where('provider_product_favorite.user_id', $spec->user_id);
        }
        $builder->select('provider_product.*');
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
     * @param int|array $id
     */
    public function delete($id)
    {
        $builder = ProviderProductModel::query();
        $builder->whereIn('id', (array)$id);
        $models = $builder->get();
        foreach ($models as $model) {
            $model->delete();
        }
        $this->deleteProductPictureById($id);
    }


    /**
     * @param int       $provider_id
     * @param int|array $status
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderProductByProviderIdAndStatus($provider_id, $status)
    {
        $collect = collect();
        $builder = ProviderProductModel::query();
        $builder->where('provider_id', $provider_id);
        $builder->whereIn('status', (array)$status);
        $models = $builder->get();
        /** @var ProviderProductModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * @param ProviderProductSpecification $spec
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderProductBySpec(ProviderProductSpecification $spec)
    {
        $collect = collect();
        $builder = ProviderProductModel::query();
        if ($spec->provider_id) {
            $builder->where('provider_id', $spec->provider_id);
        }
        if ($spec->status) {
            $builder->whereIn('status', (array)$spec->status);
        }
        if ($spec->second_product_category_id) {
            $builder->whereIn('product_category_id', $this->getThirdProductCategoryIds(
                $spec->second_product_category_id));
        }
        $models = $builder->get();
        /** @var ProviderProductModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;
    }

    /**
     * 获取主营品类ID
     * @param $provider_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderMainCategoryIds($provider_id)
    {
        $builder = ProviderMainCategoryModel::query();
        $builder->where('provider_id', $provider_id);
        $models = $builder->get();

        return $models->pluck('product_category_id')->toArray();
    }


    private function getThirdProductCategoryIds($product_category_ids)
    {
        $builder = ProductCategoryModel::query();
        $builder->where('status', ProductCategoryStatus::STATUS_ONLINE);
        $builder->where('level', 2);
        $models = $builder->get();
        return $models->pluck('id')->toArray();
    }

    /**
     * 计算产品属性完整度
     * @param array $attrib
     * @return int|string
     */
    public function countAttribIntegrity($attrib = [])
    {
        $denominator = 0;
        $molecule = 0;
        $attrib = json_decode($attrib, true);
        foreach ($attrib as $value) {
            $attrib_number = count($value['nodes']);
            $denominator += $attrib_number;
            foreach ($value['nodes'] as $val) {
                if (empty($val['value'])) {
                    continue;
                }
                $molecule++;
            }
        }
        return sprintf("%.2f", $molecule / $denominator) * 100;
    }

    /*
     * @param int|array      $ids
     * @param null|int|array $status
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderProductsByIds($ids, $status = null)
    {
        $collect = collect();
        $builder = ProviderProductModel::query();
        $builder->whereIn('id', (array)$ids);
        if (!empty($status)) {
            $builder->where('status', (array)$status);
        }
        $models = $builder->get();
        /** @var ProviderProductModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;

    }

    public function getProductCategoryByUserId($user_id, $status)
    {
        $collect = collect();
        $builder = ProviderProductModel::query();
        $builder->where('status', (array)$status);
        $builder->leftJoin('provider_product_favorite', function ($join) {
            $join->on('provider_product.id', '=', 'provider_product_favorite.provider_product_id');
            $join->whereRaw('provider_product_favorite.deleted_at is NULL');
        });
        $builder->where('provider_product_favorite.user_id', $user_id);
        $builder->select('provider_product.*');
        $models = $builder->get();
        /** @var ProviderProductModel $model */
        foreach ($models as $model) {
            $collect[] = $this->reconstituteFromModel($model);
        }
        return $collect;

    }
}