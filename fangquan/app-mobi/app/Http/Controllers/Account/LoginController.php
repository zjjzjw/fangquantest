<?php

namespace App\Mobi\Http\Controllers\Account;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Login\MobileSessionService;
use App\Mobi\Src\Forms\Login\LoginForm;
use Illuminate\Http\Request;

class LoginController extends BaseController
{
    public function index(Request $request, LoginForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $mobile_session_service = new  MobileSessionService();
        $result = $mobile_session_service->login($form->login_specification);
        if ($result['success']) {
            $data['code'] = 200;
            $data['msg'] = 'success';
            $data['data']['user_id'] = $result['user_id'];
            $data['data']['token'] = $result['token'];
            return response()->json($data, 200);
        } else {
            $data['code'] = $result['code'];
            $data['msg'] = 'failed';
            return response()->json($data, 400);
        }
    }

}


