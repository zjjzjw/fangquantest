<?php

use Illuminate\Database\Seeder;
use \App\Src\Product\Infra\Eloquent\ProductCategoryModel;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = $this->getData();
        foreach ($items as $item) {
            $product_category_model = ProductCategoryModel::find($item['id']);
            if (!isset($area_model)) {
                $product_category_model = new ProductCategoryModel();
                $product_category_model->id = $item['id'];
            }
            $product_category_model->name = $item['name'];
            $product_category_model->parent_id = $item['parent_id'];
            $product_category_model->status = $item['status'];
            $product_category_model->sort = $item['sort'];
            $product_category_model->description = $item['description'];
            $product_category_model->attribfield = $item['attribfield'];
            $product_category_model->is_leaf = $item['is_leaf'];
            $product_category_model->level = $item['level'];
            $product_category_model->save();
        }
    }

    private function getData()
    {
        return [
            [
                'id'          => 1,
                'name'        => '装饰材料',
                'parent_id'   => 0,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 1,
            ],
            [
                'id'          => 2,
                'name'        => '热水器',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 3,
                'name'        => '卫浴',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 4,
                'name'        => '橱柜',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 5,
                'name'        => '厨房电器',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 6,
                'name'        => '入户门',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 7,
                'name'        => '配电箱',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 8,
                'name'        => '木地板',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 9,
                'name'        => '管材',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 10,
                'name'        => '电梯',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 11,
                'name'        => '新风系统',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 12,
                'name'        => '室内涂料',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 13,
                'name'        => '防水材料',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 14,
                'name'        => '集成吊顶',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 15,
                'name'        => '空调',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 16,
                'name'        => '垃圾处理器',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 17,
                'name'        => '壁挂炉',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 18,
                'name'        => '瓷砖',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 19,
                'name'        => '开关面板',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 20,
                'name'        => '室内灯饰',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 21,
                'name'        => '可视对讲',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 22,
                'name'        => '室内墙纸',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 23,
                'name'        => '智能家居',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 24,
                'name'        => '净水器',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 25,
                'name'        => '收纳系统',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 26,
                'name'        => '门窗型材',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],
            [
                'id'          => 27,
                'name'        => '门窗五金',
                'parent_id'   => 1,
                'status'      => 1,
                'sort'        => 1,
                'description' => '',
                'attribfield' => '[]',
                'is_leaf'     => 0,
                'level'       => 2,
            ],

        ];
    }

}
