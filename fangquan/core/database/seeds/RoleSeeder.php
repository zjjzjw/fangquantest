<?php

use Illuminate\Database\Seeder;
use App\Src\Role\Infra\Eloquent\RoleModel;

class RoleSeeder extends Seeder
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
            $role_model = RoleModel::find($item['id']);
            if (!isset($role_model)) {
                $role_model = new RoleModel();
                $role_model->id = $item['id'];
            }
            $role_model->name = $item['name'];
            $role_model->desc = $item['desc'];
            $role_model->save();
        }
    }

    private function getData()
    {
        return [
            [
                'id'   => 1,
                'name' => '系统管理员',
                'desc' => '系统管理员',
            ],
        ];
    }
}
