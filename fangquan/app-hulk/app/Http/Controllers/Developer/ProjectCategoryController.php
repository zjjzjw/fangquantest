<?php

namespace App\Hulk\Http\Controllers\Developer;

use App\Hulk\Service\Developer\ProjectCategoryHulkService;
use App\Src\Developer\Domain\Model\DeveloperProjectBiddingType;
use App\Src\Project\Domain\Model\ProjectCategoryStatus;
use App\Web\Http\Controllers\BaseController;
use Illuminate\Http\Request;


class ProjectCategoryController extends BaseController
{

    public function index(Request $request)
    {
        $data = [];
        $project_category_service = new ProjectCategoryHulkService();
        $data['bidding_types'] = DeveloperProjectBiddingType::acceptableEnums();
        $data['project_categories'] = $project_category_service->getProjectCategoryMainList(ProjectCategoryStatus::STATUS_ONLINE);
        return response()->json($data, 200);
    }


    public function secondCategory(Request $request)
    {
        $data = [];
        $project_category_ids = $request->get('project_category_ids');
        if (!empty($project_category_ids)) {
            $project_category_ids = explode(',', $project_category_ids);
        }

        $project_category_service = new ProjectCategoryHulkService();
        $data = $project_category_service->getProjectCategoryByParentId($project_category_ids, ProjectCategoryStatus::STATUS_ONLINE);
        return response()->json($data, 200);
    }


}