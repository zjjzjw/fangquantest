<?php

namespace App\Web\Http\Controllers\Api\Account;

use App\Web\Http\Controllers\BaseController;
use App\Web\Service\Account\AccountService;
use App\Web\Src\Forms\Account\VerifyCodeForm;
use Illuminate\Http\Request;

class VerifyCodeController extends BaseController
{
    public function index(Request $request, VerifyCodeForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $mobil_login = new  AccountService();
        $mobil_login->getVerifyCode($form->verify_code_specification);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = ['success' => true];
        return response()->json($data, 200);
    }

}


