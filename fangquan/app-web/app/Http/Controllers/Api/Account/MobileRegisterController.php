<?php

namespace App\Web\Http\Controllers\Api\Account;


use App\Web\Http\Controllers\BaseController;
use App\Web\Service\Account\AccountService;
use App\Web\Src\Auth\UserCenterService;
use App\Web\Src\Forms\Account\MobileRegisterForm;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class MobileRegisterController extends BaseController
{

    public function index(Request $request, MobileRegisterForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $mobile_register = new  AccountService();
        $result = $mobile_register->mobileRegister($form->mobile_register_specification);
        \Auth::attempt($request->all());
        $data['user_id'] = $result['user_id'];
        return response()->json($data, 200);
    }


}


