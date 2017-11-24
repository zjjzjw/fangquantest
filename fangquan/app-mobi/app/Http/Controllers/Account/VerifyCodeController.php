<?php

namespace App\Mobi\Http\Controllers\Account;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Login\MobileSessionService;
use App\Mobi\Src\Forms\Account\VerifyCodeForm;
use Illuminate\Http\Request;

class VerifyCodeController extends BaseController
{
    public function index(Request $request, VerifyCodeForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $mobil_login = new  MobileSessionService();
        $mobil_login->getVerifyCode($form->verify_code_specification);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = ['success' => true];
        return response()->json($data, 200);
    }

}


