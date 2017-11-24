<?php

namespace App\Hulk\Http\Controllers\Developer;

use App\Hulk\Service\Developer\DeveloperProjectService;
use App\Hulk\Service\Developer\ProjectCategoryHulkService;
use App\Hulk\Src\Forms\Developer\DeveloperProject\DeveloperProjectSearchForm;
use App\Src\Developer\Domain\Model\DeveloperProjectSpecification;
use App\Src\Developer\Domain\Model\DeveloperProjectStatus;
use App\Src\Project\Domain\Model\ProjectCategoryStatus;
use App\Web\Http\Controllers\BaseController;
use Illuminate\Http\Request;


class DeveloperProjectController extends BaseController
{

    public function index(Request $request, DeveloperProjectSearchForm $form)
    {
        $data = [];
        $developer_project_service = new DeveloperProjectService();
        $request->merge(['status' => DeveloperProjectStatus::YES]);
        $form->validate($request->all());
        $data = $developer_project_service->getDeveloperProjectList($form->developer_project_specification, 6);
        $appends = $this->getAppends($form->developer_project_specification);
        $data['appends'] = $appends;
        return response()->json($data, 200);
    }


    public function detail(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $developer_project_service = new DeveloperProjectService();
            $data = $developer_project_service->getDeveloperProjectInfo($id);
        }
        return response()->json($data, 200);
    }


    public function getAppends(DeveloperProjectSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        if ($spec->project_categories) {
            $appends['project_categories'] = $spec->project_categories;
        }
        if ($spec->bidding_type) {
            $appends['bidding_type'] = $spec->bidding_type;
        }
        return $appends;
    }
}