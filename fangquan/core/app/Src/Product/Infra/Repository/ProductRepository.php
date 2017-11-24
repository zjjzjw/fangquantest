<?php namespace App\Src\Product\Infra\Repository;

use App\Src\Category\Domain\Model\AttributeValueEntity;
use App\Src\Category\Infra\Repository\AttributeValueRepository;
use App\Src\Product\Domain\Model\ProductSpecification;
use App\Foundation\Domain\Repository;
use App\Src\Product\Domain\Interfaces\ProductInterface;
use App\Src\Product\Domain\Model\ProductEntity;
use App\Src\Product\Infra\Eloquent\ProductAttributeValueModel;
use App\Src\Product\Infra\Eloquent\ProductDynamicParamModel;
use App\Src\Product\Infra\Eloquent\ProductHotModel;
use App\Src\Product\Infra\Eloquent\ProductModel;
use App\Src\Product\Infra\Eloquent\ProductParamModel;
use App\Src\Product\Infra\Eloquent\ProductPictureModel;
use App\Src\Theme\Domain\Model\ThemeType;


class ProductRepository extends Repository implements ProductInterface
{
    /**
     * Store an entity into persistence.
     *
     * @param ProductEntity $product_entity
     */
    protected function store($product_entity)
    {
        if ($product_entity->isStored()) {
            $model = ProductModel::find($product_entity->id);
        } else {
            $model = new ProductModel();
        }

        $model->fill(
            [
                'brand_id'            => $product_entity->brand_id,
                'product_category_id' => $product_entity->product_category_id,
                'product_model'       => $product_entity->product_model,
                'price'               => $product_entity->price,
                'created_user_id'     => $product_entity->created_user_id,
                'logo'                => $product_entity->logo,
                'comment_count'       => $product_entity->comment_count,
                'product_type'        => $product_entity->product_type,
                'product_grade'       => $product_entity->product_grade,
                'name'                => $product_entity->name,
                'price_unit'          => $product_entity->price_unit,
                'engineering_price'   => $product_entity->engineering_price,
                'product_discount_rate'   => $product_entity->product_discount_rate,
                'retail_price'        => $product_entity->retail_price,
            ]
        );
        $model->save();

        if (!empty($product_entity->product_pictures)) {
            $this->saveProductPictures($model, $product_entity->product_pictures);
        }
        if (!empty($product_entity->product_attribute_values)) {
            $this->saveProductAttributes($model, $product_entity->product_attribute_values);
        }
        if (!empty($product_entity->product_params)) {
            $this->saveProductParams($model, $product_entity->product_params);
        }
        if (isset($product_entity->product_dynamic_params)) {
            $this->saveProductDynamicParams($model, $product_entity->product_dynamic_params);
        }
        if (isset($product_entity->product_hots)) {
            $this->saveProductHots($model, $product_entity->product_hots);
        }

        $product_entity->setIdentity($model->id);
    }

    /**
     * @param ProductModel  $model
     * @param               $product_pictures
     */
    protected function saveProductPictures($model, $product_pictures)
    {
        $item = [];
        $this->deleteProductPictures($model->id);
        foreach ($product_pictures as $product_picture) {
            $item[] = new ProductPictureModel([
                'image_id' => $product_picture,
            ]);
        }
        $model->product_pictures()->saveMany($item);
    }

    protected function deleteProductPictures($id)
    {
        $product_picture_query = ProductPictureModel::query();
        $product_picture_query->where('product_id', $id);
        $product_picture_models = $product_picture_query->get();
        foreach ($product_picture_models as $product_picture_model) {
            $product_picture_model->delete();
        }
    }

    /**
     * @param ProductModel $model
     * @param   array      $product_attribute_values
     */
    protected function saveProductAttributes($model, $product_attribute_values)
    {
        $item = [];

        $this->deleteProductAttributes($model->id);
        foreach ($product_attribute_values as $product_attribute_value) {
            $item[] = new ProductAttributeValueModel([
                'value_id'     => $product_attribute_value['value_id'],
                'attribute_id' => $product_attribute_value['attribute_id'],
            ]);
        }
        $model->product_attribute_values()->saveMany($item);
    }


    protected function deleteProductAttributes($id)
    {
        $product_attribute_value_query = ProductAttributeValueModel::query();
        $product_attribute_value_query->where('product_id', $id);
        $product_attribute_value_models = $product_attribute_value_query->get();
        foreach ($product_attribute_value_models as $product_attribute_value_model) {
            $product_attribute_value_model->delete();
        }
    }

    /**
     * @param ProductModel $model
     * @param  array       $product_params
     */
    protected function saveProductParams($model, $product_params)
    {
        $item = [];
        if (isset($product_params[0]['category_param_id'])) {
            $this->deleteProductParams($model->id);
            foreach ($product_params as $product_param) {
                $item[] = new ProductParamModel([
                    'category_param_id' => $product_param['category_param_id'],
                    'name'              => $product_param['name'],
                    'value'             => $product_param['value'],
                ]);
            }
            $model->product_params()->saveMany($item);
        }
    }

    protected function deleteProductParams($id)
    {
        $product_param_query = ProductParamModel::query();
        $product_param_query->where('product_id', $id);
        $product_param_models = $product_param_query->get();
        foreach ($product_param_models as $product_param_model) {
            $product_param_model->delete();
        }
    }


    /**
     * @param ProductModel $model
     * @param array        $product_dynamic_params
     */
    protected function saveProductDynamicParams($model, $product_dynamic_params)
    {
        $product_dynamic_param_query = ProductDynamicParamModel::query();
        $product_dynamic_param_query->where('product_id', $model->id);
        $product_dynamic_param_models = $product_dynamic_param_query->get();
        foreach ($product_dynamic_param_models as $product_dynamic_param_model) {
            $product_dynamic_param_model->delete();
        }
        $items = [];
        foreach ($product_dynamic_params as $product_dynamic_param) {
            $item = new ProductDynamicParamModel($product_dynamic_param);
            $items[] = $item;
        }
        $model->product_dynamic_params()->saveMany($items);
    }

    /**
     * @param ProductModel $model
     * @param array        $product_dynamic_params
     */
    protected function saveProductHots($model, $product_hots)
    {
        $product_hot_query = ProductHotModel::query();
        $product_hot_query->where('product_id', $model->id);
        $product_hot_models = $product_hot_query->get();
        foreach ($product_hot_models as $product_hot_model) {
            $product_hot_model->delete();
        }
        $items = [];
        foreach ($product_hots as $product_hot) {
            $item = new ProductHotModel(

                ['product_hot_type'=>$product_hot]
            );
            $items[] = $item;
        }
        $model->product_hots()->saveMany($items);
    }

    /**
     * @param ProductSpecification $spec
     * @param int                  $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(ProductSpecification $spec, $per_page = 10)
    {
        $builder = ProductModel::query();

        $builder->leftJoin('brand', function ($join) use ($spec) {
            $join->on('product.brand_id', '=', 'brand.id');
        });

        if ($spec->keyword) {
            $builder->leftJoin('category', function ($join) use ($spec) {
                $join->on('product.product_category_id', '=', 'category.id');
            });
            $builder->where(function ($join) use ($spec) {
                $join->where('category.name', 'like', '%' . $spec->keyword . '%')
                    ->orWhere('brand.brand_name', 'like', '%' . $spec->keyword . '%')
                    ->orWhere('brand.company_name', 'like', '%' . $spec->keyword . '%')
                    ->orWhere('product.product_model', 'like', '%' . $spec->keyword . '%');
            });
        }
        if ($spec->brand_id) {
            $builder->where('product.brand_id', $spec->brand_id);
        }

        if (isset($spec->brand_ids)) {
            $builder->whereIn('product.brand_id', $spec->brand_ids);
        }

        if ($spec->product_category_id) {
            $builder->where('product.product_category_id', $spec->product_category_id);
        }

        if ($spec->company_type) {
            $builder->whereIn('brand.company_type', $spec->company_type);
        }
        if ($spec->product_type) {
            $builder->whereIn('brand.domestic_import', $spec->product_type);
        }

        if ($spec->attributes) {
            foreach ($spec->attributes as $key => $value) {
                $builder->whereIn('product.id', $this->getProductIdByAttribute($key, array_values($value)));
            }
        }
        $builder->select('product.*')->distinct();
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
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     *
     * @return ProductModel
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ProductModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }

    /**
     * @param ProductModel $model
     *
     * @return ProductEntity
     *
     */
    private function reconstituteFromModel($model)
    {
        $entity = new ProductEntity();
        $entity->id = $model->id;
        $entity->brand_id = $model->brand_id;
        $entity->product_category_id = $model->product_category_id;
        $entity->product_model = $model->product_model;
        $entity->price = $model->price;
        $entity->created_user_id = $model->created_user_id;
        $entity->logo = $model->logo;
        $entity->product_type = $model->product_type;
        $entity->product_grade = $model->product_grade;
        $entity->name = $model->name;
        $entity->price_unit = $model->price_unit;
        $entity->retail_price = $model->retail_price;
        $entity->engineering_price = $model->engineering_price;
        $entity->product_discount_rate = $model->product_discount_rate;

        $entity->product_pictures = $model->product_pictures->pluck('image_id')->toArray();

        $entity->product_params = $model->product_params->map(function ($item) {
            return ['value' => $item->value, 'name' => $item->name, 'category_param_id' => $item->category_param_id];
        })->toArray();
        $entity->product_attribute_values = $model->product_attribute_values->map(function ($item) {
            return ['attribute_id' => $item->attribute_id, 'value_id' => $item->value_id];
        })->toArray();
        $entity->product_dynamic_params = $model->product_dynamic_params->map(function ($item) {
            return ['param_name' => $item->param_name, 'param_value' => $item->param_value];
        })->toArray();
        $entity->product_hots = $model->product_hots->pluck('product_hot_type')->toArray();
        $entity->comment_count = $model->comment_count;
        $entity->created_at = $model->created_at;
        $entity->updated_at = $model->updated_at;
        $entity->setIdentity($model->id);
        $entity->stored();
        return $entity;
    }

    /**
     * @param int|array $ids
     */
    public function delete($ids)
    {
        $builder = ProductModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        /** @var ProductModel $model */
        foreach ($models as $model) {
            $product_params = $model->product_params()->pluck('id')->toArray();
            if ($product_params) {
                $this->deleteProductParams($model->id);
            }

            $product_attribute_values = $model->product_attribute_values()->pluck('id')->toArray();
            if ($product_attribute_values) {
                $this->deleteProductAttributes($model->id);
            }

            $product_pictures = $model->product_pictures()->pluck('id')->toArray();
            if ($product_pictures) {
                $this->deleteProductPictures($model->id);
            }
            $model->delete();
        }
    }

    /**
     * @param  int $id
     */
    public function updateCommentCount($id)
    {
        /** @var ProductEntity $entity */
        $entity = $this->fetch($id);
        if (isset($entity)) {
            $entity->comment_count = $entity->comment_count + 1;
            $this->save($entity);
        }
    }

    /**
     * @return array|\Illuminate\Support\Collection
     */
    public function all()
    {
        $collection = collect();
        $builder = ProductModel::query();
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }

    public function getProductListByBrandId($brand_id)
    {
        $collection = collect();
        $builder = ProductModel::query();
        $builder->where('brand_id', $brand_id);
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }

    public function getProductCountByBrandId($brand_id)
    {
        $builder = ProductModel::query();
        $builder->where('brand_id', $brand_id);
        $count = $builder->count();
        return $count;
    }

    public function getProductAvgPriceByBrandId($brand_id)
    {
        $builder = ProductModel::query();
        $builder->where('brand_id', $brand_id);
        $avg = $builder->avg('price');
        return $avg;
    }

    public function getProductListByProductModel($product_model)
    {
        $collection = collect();
        $builder = ProductModel::query();
        $builder->where('product_model', 'like', '%' . $product_model . '%');
        $models = $builder->get();
        foreach ($models as $model) {
            $collection[] = $this->reconstituteFromModel($model);
        }
        return $collection;
    }
}