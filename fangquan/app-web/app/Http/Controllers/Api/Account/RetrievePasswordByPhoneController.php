<?php

namespace App\Web\Http\Controllers\Api\Account;

use App\Web\Http\Controllers\BaseController;
use App\Web\Service\Account\AccountService;
use App\Web\Src\Forms\Account\RetrievePasswordByPhoneForm;
use Illuminate\Http\Request;

class RetrievePasswordByPhoneController extends BaseController
{
    public function index(Request $request, RetrievePasswordByPhoneForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $check_third_party = new  AccountService();
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


