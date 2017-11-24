<?php

namespace App\Mobi\Http\Controllers\Account;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Login\MobileSessionService;
use App\Mobi\Service\Login\MobilSessionService;
use App\Mobi\Src\Forms\Account\MobileRegisterForm;
use App\Mobi\Src\Forms\Account\ThirdPartyRegisterForm;
use App\Mobi\Src\Forms\Provider\LoginSearchForm;
use Illuminate\Http\Request;

class ThirdPartyRegisterController extends BaseController
{
    public function index(Request $request, ThirdPartyRegisterForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $third_party_register = new  MobileSessionService();
        $request = $third_party_register->thirdPartyRegister($form->third_party_register_specification);

        if ($request['success']) {
            $data['code'] = 200;
            $data['msg'] = 'success';
            $result['user_id'] = $request['user_id'];
            $result['token'] = $request['token'];
            $data['data'] = $result;
            return response()->json($data, 200);
        } else {
            $data['code'] = $request['code'];
            $data['msg'] = 'failed';
            return response()->json($data, 400);
        }
    }

}


