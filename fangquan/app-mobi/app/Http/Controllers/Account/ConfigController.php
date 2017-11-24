<?php

namespace App\Mobi\Http\Controllers\Account;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Login\MobileSessionService;
use App\Mobi\Src\Forms\Account\ConfigForm;
use App\Mobi\Src\Forms\Login\LoginForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ConfigController extends BaseController
{
    public function index(Request $request, ConfigForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $mobile_session_service = new  MobileSessionService();
        $result = $mobile_session_service->updateNotifyConfig($form->config_specification);
        if ($result['success']) {
            $data['code'] = 200;
            $data['msg'] = 'success';
            return response()->json($data, 200);
        } else {
            $data['code'] = $result['code'];
            $data['msg'] = 'failed';
            return response()->json($data, 400);
        }
    }

}


