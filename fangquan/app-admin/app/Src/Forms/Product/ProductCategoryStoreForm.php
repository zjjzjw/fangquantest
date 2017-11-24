<?php

namespace App\Admin\Src\Forms\Product;

use App\Src\Product\Infra\Repository\ProductCategoryRepository;
use App\Src\Product\Domain\Model\ProductCategoryEntity;
use App\Admin\Src\Forms\Form;

/**
 * @property mixed product_category_entity
 */
class ProductCategoryStoreForm extends Form
{
    /** @var  ProductCategoryEntity */
    public $product_category_entity;

    public function validation()
    {
        $attrib = json_encode($this->regroupAttrib($this->data));

        if ($id = array_get($this->data, 'id')) { //修改
            $product_category_repository = new ProductCategoryRepository();
            /** @var ProductCategoryEntity $product_category_entity */
            $product_category_entity = $product_category_repository->fetch($id);
        } else {
            $product_category_entity = new ProductCategoryEntity();
            if (($level = array_get($this->data, 'level')) < 3) {
                $product_category_entity->is_leaf = 0;
            } else {
                $product_category_entity->is_leaf = 1;
            }
            $product_category_entity->parent_id = array_get($this->data, 'parent_id');
            $product_category_entity->level = $level;
        }

        $product_category_entity->attribfield = $attrib;
        $product_category_entity->sort = array_get($this->data, 'sort');
        $product_category_entity->name = array_get($this->data, 'name');
        $product_category_entity->status = array_get($this->data, 'status');
        $product_category_entity->icon = array_get($this->data, 'icon') ?? '';
        $product_category_entity->logo = array_get($this->data, 'logo') ?? 0;
        $product_category_entity->description = array_get($this->data, 'description') ?? '';

        $this->product_category_entity = $product_category_entity;
    }

    /**
     * 重组产品参数属性为json数据
     * @param $params
     * @return string
     */
    public function regroupAttrib($params)
    {
        $items = [];
        $result = [];
        if (!empty($params['product'])) {
            $categories = $params['product'];
            $result['name'] = $categories['category-param-name'];
            $result['key'] = $categories['category-param-key'];
            $result['param'] = [];
            foreach ($categories as $key => $param) {
                if (strpos($key, 'category-param') !== false && strpos($key, 'category-param-') === false) {
                    $result['param'][] = $param;
                }
            }
            $result = $this->formatDataFromHorToVert($result);

            foreach ($result as $row) {
                $item = [];
                $item['id'] = $row['key'];
                $item['name'] = $row['name'];
                $item['type'] = 'string';
                $item['key'] = $row['key'];
                $item['value'] = '';
                $item['nodes'] = [];
                if (!empty($row['param'])) {
                    $params = $this->formatDataFromHorToVert($row['param']);
                    foreach ($params as $param) {
                        $param_item = [];
                        $param_item['id'] = $param['param-key'];
                        $param_item['name'] = $param['param-name'];
                        $param_item['type'] = 'string';
                        $param_item['key'] = $param['param-key'];
                        $param_item['value'] = '';
                        $item['nodes'][] = $param_item;
                    }
                }
                $items[] = $item;
            }
        }
        return $items;
    }

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'    => 'required|string',
            'status'  => 'required|integer',
            'sort'    => 'required|integer',
            'logo'    => 'nullable|integer',
            'icon'    => 'nullable|string',
            'product' => 'nullable|array',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
        ];
    }

    public function attributes()
    {
        return [
            'name'        => '分类名称',
            'status'      => '分类显示状态',
            'sort'        => '排序',
            'product'     => '产品参数',
            'description' => '描述',
            'keyword'     => '关键字',
            'icon'        => 'icon',
            'logo'        => 'logo',
        ];
    }


}