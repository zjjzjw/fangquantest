<?php

namespace App\Mobi\Http\Controllers\Developer;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Developer\DeveloperProjectStageMobiService;
use Illuminate\Http\Request;

class DeveloperProjectStageController extends BaseController
{
    public function projectStage(Request $request)
    {
        $data = [];
        $developer_project_stage_mobi_service = new DeveloperProjectStageMobiService();
        $items = $developer_project_stage_mobi_service->getDeveloperProjectStageList();
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $items;
        return response()->json($data, 200);
    }

}


