<?php

namespace App\Mobi\Http\Controllers\FqUser;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\FqUser\UserInfoService;
use App\Service\FqUser\CheckTokenService;
use App\Src\Exception\LoginException;
use Illuminate\Http\Request;


class InfoController extends BaseController
{
    /**
     * 获取个人资料
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LoginException
     */
    public function index(Request $request)
    {
        $data = [];
        if (!CheckTokenService::isLogin()) {
            throw new LoginException('', LoginException::ERROR_NO_LOGIN);
        }
        $user_id = CheckTokenService::getUserId();
        $fq_user_service = new  UserInfoService();
        $result = $fq_user_service->getUserInfoByUserId($user_id);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $result;
        return response()->json($data, 200);
    }

    /**
     * 修改个人资料
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LoginException
     */
    public function edit(Request $request)
    {
        $data = [];

        if (!CheckTokenService::isLogin()) {
            throw new LoginException('', LoginException::ERROR_NO_LOGIN);
        }
        $user_id = CheckTokenService::getUserId();
        $fq_user_service = new  UserInfoService();
        $param = $request->all();
        $result = $fq_user_service->editUserInfoByUserId($user_id, $param);
        if ($result['success']) {
            $data['code'] = 200;
            $data['msg'] = 'success';
            $data['data'] = $result;
            return response()->json($data, 200);
        } else {
            $data['code'] = 400;
            $data['msg'] = 'success';
            $data['data'] = $result;
            return response()->json($data, 400);
        }
    }

}


