<?php namespace App\Admin\Http\Controllers\Developer;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Developer\DeveloperProjectStage\DeveloperProjectStageTimeSearchForm;
use App\Service\Developer\DeveloperProjectContactService;
use App\Service\Developer\DeveloperProjectStageService;
use App\Service\Developer\DeveloperProjectStageTimeService;
use App\Src\Developer\Domain\Model\DeveloperProjectContactType;
use App\Src\Developer\Domain\Model\DeveloperProjectStageTimeSpecification;
use App\Src\Developer\Infra\Repository\DeveloperProjectStageRepository;
use Illuminate\Http\Request;

/**
 * 项目阶段
 * Class DeveloperProjectStageController
 * @package App\Admin\Http\Controllers\Developer
 */
class DeveloperProjectStageTimeController extends BaseController
{
    public function index(Request $request, DeveloperProjectStageTimeSearchForm $form, $project_id)
    {
        $data = [];
        $developer_project_stage_time_service = new DeveloperProjectStageTimeService();
        $request->merge(['project_id' => $project_id]);
        $form->validate($request->all());
        $data = $developer_project_stage_time_service->getDeveloperProjectStageTimeContactList($form->developer_project_stage_time_specification, 20);

        $appends = $this->getAppends($form->developer_project_stage_time_specification);
        $data['appends'] = $appends;
        $data['project_id'] = $project_id;
        $view = $this->view('pages.developer.developer-project-stage.index', $data);
        return $view;
    }

    public function edit(Request $request, $project_id, $id)
    {
        $data = [];
        if (!empty($id) || !empty($project_id)) {
            $developer_project_stage_time_service = new DeveloperProjectStageTimeService();
            $data = $developer_project_stage_time_service->getDeveloperProjectStageTimeInfo($id);
        }
        $developer_project_stage_service = new DeveloperProjectStageService();
        $data['developer_project_stage_list'] = $developer_project_stage_service->getDeveloperProjectStageList();
        $data['project_id'] = $project_id;
        $view = $this->view('pages.developer.developer-project-stage.edit', $data);
        return $view;
    }

    public function getAppends(DeveloperProjectStageTimeSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
            $appends['project_id'] = $spec->project_id;
        }
        return $appends;
    }
}
