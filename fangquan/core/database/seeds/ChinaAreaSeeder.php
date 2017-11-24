<?php

use Illuminate\Database\Seeder;
use App\Src\Surport\Infra\Eloquent\ChinaAreaModel;

class ChinaAreaSeeder extends Seeder
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
            $area_model = ChinaAreaModel::find($item['id']);
            if (!isset($area_model)) {
                $area_model = new ChinaAreaModel();
                $area_model->id = $item['id'];
            }
            $area_model->name = $item['name'];
            $area_model->save();
        }
    }

    private function getData()
    {
        return [
            [
                'id'   => 1,
                'name' => '华北',
            ],
            [
                'id'   => 2,
                'name' => '华南',
            ],
            [
                'id'   => 3,
                'name' => '华东',
            ],
            [
                'id'   => 4,
                'name' => '华中',
            ],
            [
                'id'   => 5,
                'name' => '东北',
            ],
            [
                'id'   => 6,
                'name' => '西北',
            ],
            [
                'id'   => 7,
                'name' => '西南',
            ],
            [
                'id'   => 8,
                'name' => '华西',
            ],
        ];
    }

}
