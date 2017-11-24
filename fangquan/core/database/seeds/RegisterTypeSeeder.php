<?php

use Illuminate\Database\Seeder;
use App\Src\FqUser\Infra\Eloquent\RegisterTypeModel;

class RegisterTypeSeeder extends Seeder
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
            $role_model = RegisterTypeModel::find($item['id']);
            if (!isset($role_model)) {
                $role_model = new RegisterTypeModel();
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
                'name' => '手机',
            ],
            [
                'id'   => 2,
                'name' => '邮箱',
            ],
            [
                'id'   => 3,
                'name' => '微信',
            ],
            [
                'id'   => 4,
                'name' => '微博',
            ],
            [
                'id'   => 5,
                'name' => 'QQ',
            ],
            [
                'id'   => 6,
                'name' => '用户名',
            ],

        ];
    }

}
