<?php

use Illuminate\Database\Seeder;
use App\Src\FqUser\Infra\Eloquent\PlatformModel;

class PlatformSeeder extends Seeder
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
            $platform_model = PlatformModel::find($item['id']);
            if (!isset($platform_model)) {
                $platform_model = new PlatformModel();
                $platform_model->id = $item['id'];
            }
            $platform_model->name = $item['name'];
            $platform_model->save();
        }
    }

    private function getData()
    {
        return [
            [
                'id'   => 1,
                'name' => 'PC',
            ],
            [
                'id'   => 2,
                'name' => 'Android',
            ],
            [
                'id'   => 3,
                'name' => 'iOS',
            ],
            [
                'id'   => 4,
                'name' => 'Admin',
            ],

        ];
    }
}
