<?php

namespace App\Mobi\Http\Controllers\Provider;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Provider\ProviderProjectMobiService;
use App\Src\Provider\Domain\Model\ProviderProjectStatus;
use Illuminate\Http\Request;

class ProviderProjectController extends BaseController
{
    public function providerProjects(Request $request, $id)
    {
        $data = [];


        $provider_project_mobi_service = new ProviderProjectMobiService();
        $provider_projects = $provider_project_mobi_service->getProviderProjectsByIdAndStatus(
            $id, ProviderProjectStatus::STATUS_PASS);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $provider_projects;
        return response()->json($data, 200);
    }


    public function detail(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_project_mobi_service = new ProviderProjectMobiService();
        $project = $provider_project_mobi_service->getProviderProjectById($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

}


