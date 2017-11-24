<?php

namespace App\Console\Commands\Import;

use App\Src\Developer\Domain\Model\DeveloperProjectAdType;
use App\Src\Developer\Domain\Model\DeveloperProjectContactType;
use App\Src\Developer\Domain\Model\DeveloperProjectStatus;
use App\Src\Developer\Domain\Model\DeveloperType;
use App\Src\Developer\Infra\Eloquent\DeveloperProjectModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * 项目数据导入
 * Class ImportDeveloperProject
 * @package App\Console\Commands\Import
 */
class ImportDeveloperProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:developer:project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $projects = DB::connection('spider')->select("select * from `developer_project`");
        foreach ($projects as $project) {

            $developer_project_model = DeveloperProjectModel::find($project->id);
            if (!isset($developer_project_model)) {
                $developer_project_model = new DeveloperProjectModel();
            }
            $developer_project_model->id = $project->id;
            $developer_project_model->name = $project->name;
            $developer_project_model->time = $project->time;
            $developer_project_model->developer_id = $project->developer_id;
            $developer_project_model->project_stage_id = $project->project_stage_id;
            $developer_project_model->is_great = $project->is_great;
            $developer_project_model->developer_type = DeveloperType::TOP_HUNDRED;
            $developer_project_model->province_id = $project->province_id;
            $developer_project_model->city_id = $project->city_id;
            $developer_project_model->address = $project->address;
            $developer_project_model->cost = $project->cost;
            $developer_project_model->views = $project->views;
            $developer_project_model->type = $project->type;
            $developer_project_model->project_category = $project->project_category;
            $developer_project_model->time_start = $project->time_start;
            $developer_project_model->time_end = $project->time_end;
            $developer_project_model->stage_design = $project->stage_design;
            $developer_project_model->stage_build = $project->stage_build;
            $developer_project_model->stage_decorate = $project->stage_decorate;
            $developer_project_model->floor_space = $project->floor_space;
            $developer_project_model->floor_numbers = $project->floor_numbers;
            $developer_project_model->investments = $project->investments;
            $developer_project_model->heating_mode = $project->heating_mode;
            $developer_project_model->wall_materials = $project->wall_materials;
            $developer_project_model->has_decorate = $project->has_decorate;
            $developer_project_model->has_airconditioner = $project->has_airconditioner;
            $developer_project_model->has_steel = $project->has_steel;
            $developer_project_model->has_elevator = $project->has_elevator;
            $developer_project_model->summary = $project->summary;
            $developer_project_model->status = DeveloperProjectStatus::YES;
            $developer_project_model->is_ad = DeveloperProjectAdType::NO;
            $developer_project_model->source = $project->source;

            $developer_project_model->save();

            $this->info($project->id . '导入完成！');

        }
        $this->info('导入结束');
    }
}
