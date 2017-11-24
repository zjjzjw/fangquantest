<?php

namespace App\Admin\Src\Forms\Product;


use App\Admin\Src\Forms\Form;
use App\Src\Category\Domain\Model\AttributeValueEntity;
use App\Src\Category\Infra\Repository\AttributeValueRepository;
use App\Src\Product\Domain\Model\ProductEntity;
use App\Src\Product\Infra\Repository\ProductRepository;

class ProductStoreForm extends Form
{
    /**
     * @var ProductEntity
     */
    public $product_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                    => 'required|integer',
            'brand_id'              => 'required|integer',
            'product_category_id'   => 'required|integer',
            'product_model'         => 'required|string',
            'price'                 => 'nullable|string',
            'engineering_price'     => 'nullable|string',
            'product_discount_rate' => 'nullable|numeric',
            'retail_price'          => 'nullable|string',
            'price_unit'            => 'nullable|string',
            'name'                  => 'nullable|string',
            'logo'                  => 'nullable|integer',
            'product_grade'         => 'nullable|integer',
            'product_type'          => 'nullable|integer',
            'product_pictures'      => 'nullable|array',
            'product_attribute_ids' => 'nullable|array',
            'product_param_value'   => 'nullable|array',
            'product_dynamic'       => 'nullable|array',
            'product_hots'           => 'nullable|array',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误。',
        ];
    }

    public function attributes()
    {
        return [
            'id'                    => '标识',
            'brand_id'              => '品牌',
            'product_model'         => '产品型号',
            'price'                 => '面价',
            'engineering_price'     => '工程指导价',
            'product_discount_rate' => '产品参考折扣率',
            'retail_price'          => '零售指导价',
            'logo'                  => '封面',
            'product_grade'         => '档次',
            'product_type'          => '类型',
            'product_pictures'      => '产品图片',
            'product_attribute_ids' => '属性',
            'product_param_value'   => '自定义参数',
            'name'                  => '名称',
            'price_unit'            => '面价单位',
            'product_dynamic'       => '动态参数',
            'product_hots'           => '产品热度',
        ];
    }

    public function validation()
    {
        $product_param_values = array_get($this->data, 'product_param_value');
        if ($id = array_get($this->data, 'id')) {
            $product_repository = new ProductRepository();
            $product_entity = $product_repository->fetch(array_get($this->data, 'id'));
        } else {
            $product_entity = new ProductEntity();
            $product_entity->comment_count = 0;
            $product_entity->created_user_id = request()->user()->id;
        }
        $attribute_value_repository = new AttributeValueRepository();

        $product_attributes = [];
        $product_attribute_ids = array_get($this->data, 'product_attribute_ids');

        if (!empty($product_attribute_ids)) {
            foreach ($product_attribute_ids as $product_attribute_id) {
                /** @var AttributeValueEntity $attribute_value_entity */
                $attribute_value_entity = $attribute_value_repository->fetch($product_attribute_id);
                $item_attribute['value_id'] = $attribute_value_entity->id;
                $item_attribute['attribute_id'] = $attribute_value_entity->attribute_id;
                $product_attributes[] = $item_attribute;
            }
        }

        $product_entity->brand_id = array_get($this->data, 'brand_id');
        $product_entity->product_category_id = array_get($this->data, 'product_category_id');
        $product_entity->product_model = array_get($this->data, 'product_model');
        $product_entity->price = array_get($this->data, 'price') ?? 0;
        $product_entity->retail_price = array_get($this->data, 'retail_price') ?? 0;
        $product_entity->engineering_price = array_get($this->data, 'engineering_price') ?? 0;
        $product_entity->product_discount_rate = array_get($this->data, 'product_discount_rate') ?? 0;
        $product_entity->logo = array_get($this->data, 'logo');
        $product_entity->product_grade = array_get($this->data, 'product_grade') ?? 0;
        $product_entity->product_type = array_get($this->data, 'product_type') ?? 0;
        $product_entity->product_pictures = array_get($this->data, 'product_pictures');
        $product_entity->price_unit = array_get($this->data, 'price_unit');
        $product_entity->name = array_get($this->data, 'name') ?? '';
        $product_entity->product_attribute_values = $product_attributes;

        $items = [];
        if (!empty($product_param_values)) {
            foreach ($product_param_values as $product_param_value) {
                $product_param_value = explode(',', $product_param_value);
                $item_param['category_param_id'] = $product_param_value[0];
                $item_param['name'] = $product_param_value[1];
                $item_param['value'] = $product_param_value[2];
                $items[] = $item_param;
            }
        }
        $product_entity->product_params = $items;

        $product_dynamic = array_get($this->data, 'product_dynamic');
        if (!empty($product_dynamic)) {
            $product_dynamic_params = $this->formatDataFromHorToVert($product_dynamic);
            $product_entity->product_dynamic_params = $product_dynamic_params;
        } else {
            $product_entity->product_dynamic_params = [];
        }
        $product_hots = array_get($this->data, 'product_hots');
        $product_entity->product_hots = $product_hots ?? [];
        $this->product_entity = $product_entity;
    }

}