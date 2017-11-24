<?php

namespace App\Web\Http\Controllers\Api\Developer;

use App\Service\Developer\DeveloperProjectContactService;
use App\Web\Http\Controllers\BaseController;
use App\Web\Src\Forms\Developer\DeveloperProjectContact\DeveloperProjectContactSearchForm;
use Illuminate\Http\Request;

class DeveloperProjectContactController extends BaseController
{
    public function index(Request $request, DeveloperProjectContactSearchForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $developer_project_contact_service = new DeveloperProjectContactService();
        $data = $developer_project_contact_service->getDeveloperProjectContactInfoByProjectId($form->developer_project_contact_specification->developer_project_id);
        $data = $developer_project_contact_service->formatProjectContact($data);
        //插入获取记录
        $developer_project_contact_service->storeDeveloperProjectContactVisitLog(
            $form->developer_project_contact_specification->developer_project_id
        );
        return response()->json($data, 200);
    }
}