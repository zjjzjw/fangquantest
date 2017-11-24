<?php

use Illuminate\Database\Seeder;
use App\Src\Developer\Infra\Eloquent\DeveloperProjectStageModel;

class DeveloperProjectStageSeeder extends Seeder
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
            $developer_project_stage_model = DeveloperProjectStageModel::find($item['id']);
            if (!isset($developer_project_stage_model)) {
                $developer_project_stage_model = new DeveloperProjectStageModel();
                $developer_project_stage_model->id = $item['id'];
            }
            $developer_project_stage_model->id = $item['id'];
            $developer_project_stage_model->name = $item['name'];
            $developer_project_stage_model->sort = $item['sort'];
            $developer_project_stage_model->save();
        }
    }

    private function getData()
    {
        return [
            [
                'id'   => 1,
                'name' => '构思',
                'sort' => 0,
            ],
            [
                'id'   => 2,
                'name' => '设计',
                'sort' => 1,
            ],
            [
                'id'   => 3,
                'name' => '文章草议',
                'sort' => 2,
            ],
            [
                'id'   => 4,
                'name' => '施工单位招标',
                'sort' => 3,
            ],
            [
                'id'   => 5,
                'name' => '截标后',
                'sort' => 4,
            ],
            [
                'id'   => 6,
                'name' => '主体工程中标/开工',
                'sort' => 5,
            ],
            [
                'id'   => 7,
                'name' => '室内装修/封顶后分包工程',
                'sort' => 6,
            ],
            [
                'id'   => 8,
                'name' => '未知',
                'sort' => 7,
            ],
        ];
    }
}
