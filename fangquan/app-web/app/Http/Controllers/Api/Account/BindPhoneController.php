<?php

namespace App\Web\Http\Controllers\Api\Account;

use App\Web\Http\Controllers\BaseController;
use App\Web\Src\Forms\Account\BindPhoneForm;
use App\Web\Service\Account\AccountService;
use Illuminate\Http\Request;

class BindPhoneController extends BaseController
{
    public function index(Request $request, BindPhoneForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $account_service = new  AccountService();
        $result = $account_service->bindPhone($form->bind_phone_specification);
        if ($result['success']) {
            $data['code'] = 200;
            $data['msg'] = 'success';
            $data['data'] = $result;
            return response()->json($data, 200);
        } else {
            $data['code'] = 400;
            $data['msg'] = 'success';
            return response()->json($data, 400);
        }
    }

}


