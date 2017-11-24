<?php

namespace App\Mobi\Http\Controllers\Developer;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Provider\ProviderMobiService;
use App\Mobi\Src\Forms\Developer\DeveloperProject\DeveloperProjectSearchForm;
use App\Mobi\Src\Forms\Provider\ProviderSearchForm;
use App\Src\Provider\Infra\Eloquent\ProviderModel;
use Illuminate\Http\Request;

class DeveloperController extends BaseController
{
    public function index(Request $request, DeveloperProjectSearchForm $form)
    {
        $data = [];
        $form->validate($request->all());

        $data['code'] = 200;
        $data['msg'] = 'success';
        return response()->json($data, 200);
    }

    public function detail(Request $request, $id)
    {
        $data = [];

        $data['code'] = 200;
        $data['msg'] = 'success';

        return response()->json($data, 200);
    }

}


