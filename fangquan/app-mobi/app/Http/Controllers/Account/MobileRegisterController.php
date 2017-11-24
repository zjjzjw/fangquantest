<?php

namespace App\Mobi\Http\Controllers\Account;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Login\MobileSessionService;
use App\Mobi\Service\Login\MobilSessionService;
use App\Mobi\Src\Forms\Account\MobileRegisterForm;
use App\Mobi\Src\Forms\Provider\LoginSearchForm;
use Illuminate\Http\Request;

class MobileRegisterController extends BaseController
{
    public function index(Request $request, MobileRegisterForm $form)
    {

        $data = [];
        $form->validate($request->all());
        $mobile_register = new  MobileSessionService();
        $request = $mobile_register->mobileRegister($form->mobile_register_specification);
        if ($request['success']) {
            $data['code'] = 200;
            $data['msg'] = 'success';
            $result_info['user_id'] = $request['user_id'];
            $result_info['token'] = $request['token'];
            $data['data'] = $result_info;
            return response()->json($data, 200);
        } else {
            $data['code'] = $request['code'];
            $data['msg'] = 'failed';
            return response()->json($data, 400);
        }
    }

}


