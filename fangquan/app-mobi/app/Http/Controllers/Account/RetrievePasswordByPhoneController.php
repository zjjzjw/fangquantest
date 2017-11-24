<?php

namespace App\Mobi\Http\Controllers\Account;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Login\MobileSessionService;
use App\Mobi\Service\Login\MobilSessionService;
use App\Mobi\Src\Forms\Account\CheckThirdPartyForm;
use App\Mobi\Src\Forms\Account\MobileRegisterForm;
use App\Mobi\Src\Forms\Account\RetrievePasswordByPhoneForm;
use App\Mobi\Src\Forms\Account\ThirdPartyRegisterForm;
use App\Mobi\Src\Forms\Provider\LoginSearchForm;
use Illuminate\Http\Request;

class RetrievePasswordByPhoneController extends BaseController
{
    public function index(Request $request, RetrievePasswordByPhoneForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $check_third_party = new  MobileSessionService();
        $request = $check_third_party->retrievePasswordByPhone($form->retrieve_password_by_phone_specification);
        if ($request['success']) {
            $data['code'] = $request['code'];
            $data['msg'] = 'success';
            $data['data'] = ['success' => true];
            return response()->json($data, 200);
        } else {
            $data['code'] = $request['code'];
            $data['msg'] = 'success';
            $data['data'] = ['success' => false];
            return response()->json($data, 400);
        }
    }

}


