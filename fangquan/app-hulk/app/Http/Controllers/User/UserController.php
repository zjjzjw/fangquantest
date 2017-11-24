<?php

namespace App\Hulk\Http\Controllers\User;

use App\Hulk\Http\Controllers\BaseController;
use App\Hulk\Service\User\UserHulkService;
use App\Hulk\Src\Forms\User\UserLoginForm;
use Illuminate\Http\Request;

class UserController extends BaseController
{

    public function login(Request $request, UserLoginForm $form)
    {
        $data = [];
        $form->validate($request->all());

        $user_api_service = new UserHulkService();
        $user_info = $user_api_service->getUserInfo($form->openid, $request->all());
        $data['user_id'] = $user_info['id'];
        $data['open_id'] = $form->openid;
        return response()->json($data, 200);
    }

    public function userInfo(Request $request)
    {
        $data = [];
        $user_hulk_service = new UserHulkService();
        $data = $user_hulk_service->getFqUserInfo(1);
        return response()->json($data, 200);
    }
}


