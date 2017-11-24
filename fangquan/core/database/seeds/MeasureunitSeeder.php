<?php

use Illuminate\Database\Seeder;
use App\Src\Provider\Infra\Eloquent\MeasureunitModel;

class MeasureunitSeeder extends Seeder
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
            $role_model = MeasureunitModel::find($item['id']);
            if (!isset($role_model)) {
                $role_model = new MeasureunitModel();
                $role_model->id = $item['id'];
            }
            $role_model->name = $item['name'];
            $role_model->save();
        }
    }

    private function getData()
    {
        return [
            [
                'id'   => 1,
                'name' => '米',
            ],
            [
                'id'   => 2,
                'name' => '平方米',
            ],
            [
                'id'   => 3,
                'name' => '立方米',
            ],
            [
                'id'   => 4,
                'name' => '斤',
            ],
            [
                'id'   => 5,
                'name' => '公斤',
            ],
            [
                'id'   => 6,
                'name' => '吨',
            ],
            [
                'id'   => 7,
                'name' => '个',
            ],
            [
                'id'   => 8,
                'name' => '把',
            ],
            [
                'id'   => 9,
                'name' => '桶',
            ],
            [
                'id'   => 10,
                'name' => '套',
            ],
            [
                'id'   => 11,
                'name' => '批',
            ],
        ];
    }

}
