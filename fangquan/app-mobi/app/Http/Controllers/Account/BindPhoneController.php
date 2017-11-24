<?php

namespace App\Mobi\Http\Controllers\Account;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Login\MobileSessionService;
use App\Mobi\Src\Forms\Account\BindPhoneForm;
use Illuminate\Http\Request;

class BindPhoneController extends BaseController
{
    public function index(Request $request, BindPhoneForm $form)
    {

        $data = [];
        $form->validate($request->all());
        $bind_phone = new  MobileSessionService();
        $result = $bind_phone->bindPhone($form->bind_phone_specification);
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


