<?php

namespace App\Web\Http\Controllers\Developer;

use App\Web\Http\Controllers\BaseController;
use App\Web\Service\Developer\DeveloperWebService;
use App\Web\Src\Forms\Developer\DeveloperSearchForm;
use Illuminate\Http\Request;


class DeveloperController extends BaseController
{
    public function index(Request $request, DeveloperSearchForm $form)
    {
        $data = [];
        $form->validate($request->all());

        $provider_web_service = new DeveloperWebService();
        $providers = $provider_web_service->getAllDeveloperList();
        $providers = $provider_web_service->formatDevelopersForWeb($providers);
        $data['providers'] = $providers;
        return $this->view('pages.developer.list', $data);
    }

}