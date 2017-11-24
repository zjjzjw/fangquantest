<?php

use Illuminate\Database\Seeder;
use App\Src\Surport\Infra\Eloquent\ProvinceModel;

class ProvinceSeeder extends Seeder
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
            $province_model = ProvinceModel::find($item['id']);
            if (!isset($province_model)) {
                $province_model = new ProvinceModel();
                $province_model->id = $item['id'];
            }
            $province_model->name = $item['name'];
            $province_model->area_id = $item['area_id'];
            $province_model->save();
        }
    }

    private function getData()
    {
        return [
            //华北
            ['id' => 1, 'name' => '北京', 'area_id' => 1,],
            ['id' => 2, 'name' => '天津', 'area_id' => 1,],
            ['id' => 3, 'name' => '河北', 'area_id' => 1,],
            ['id' => 4, 'name' => '山西', 'area_id' => 1,],
            ['id' => 5, 'name' => '内蒙古', 'area_id' => 1,],
            //华南
            ['id' => 6, 'name' => '广东', 'area_id' => 2,],
            ['id' => 7, 'name' => '海南', 'area_id' => 2,],
            ['id' => 8, 'name' => '香港', 'area_id' => 2,],
            ['id' => 9, 'name' => '澳门', 'area_id' => 2,],
            //华东
            ['id' => 10, 'name' => '上海', 'area_id' => 3,],
            ['id' => 11, 'name' => '江苏', 'area_id' => 3,],
            ['id' => 12, 'name' => '浙江', 'area_id' => 3,],
            ['id' => 13, 'name' => '安徽', 'area_id' => 3,],
            ['id' => 14, 'name' => '福建', 'area_id' => 3,],
            ['id' => 15, 'name' => '江西', 'area_id' => 3,],
            ['id' => 16, 'name' => '山东', 'area_id' => 3,],
            ['id' => 17, 'name' => '台湾', 'area_id' => 3,],
            //华中
            ['id' => 18, 'name' => '河南', 'area_id' => 4,],
            ['id' => 19, 'name' => '湖北', 'area_id' => 4,],
            ['id' => 20, 'name' => '湖南', 'area_id' => 4,],
            //东北
            ['id' => 21, 'name' => '辽宁', 'area_id' => 5,],
            ['id' => 22, 'name' => '吉林', 'area_id' => 5,],
            ['id' => 23, 'name' => '黑龙江', 'area_id' => 5,],
            //西北
            ['id' => 24, 'name' => '陕西', 'area_id' => 6,],
            ['id' => 25, 'name' => '甘肃', 'area_id' => 6,],
            ['id' => 26, 'name' => '青海', 'area_id' => 6,],
            ['id' => 27, 'name' => '宁夏', 'area_id' => 6,],
            ['id' => 28, 'name' => '新疆', 'area_id' => 6,],
            //西南
            ['id' => 29, 'name' => '重庆', 'area_id' => 7,],
            ['id' => 30, 'name' => '广西', 'area_id' => 7,],
            ['id' => 31, 'name' => '四川', 'area_id' => 7,],
            ['id' => 32, 'name' => '贵州', 'area_id' => 7,],
            ['id' => 33, 'name' => '云南', 'area_id' => 7,],
            ['id' => 34, 'name' => '西藏', 'area_id' => 7,],
        ];

    }

}
