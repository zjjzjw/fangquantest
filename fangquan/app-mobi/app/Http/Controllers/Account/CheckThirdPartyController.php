<?php

namespace App\Mobi\Http\Controllers\Account;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Login\MobileSessionService;
use App\Mobi\Src\Forms\Account\CheckThirdPartyForm;
use Illuminate\Http\Request;

class CheckThirdPartyController extends BaseController
{
    public function index(Request $request, CheckThirdPartyForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $check_third_party = new  MobileSessionService();
        $request = $check_third_party->checkThirdPartyRegister($form->check_third_party_specification);
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


