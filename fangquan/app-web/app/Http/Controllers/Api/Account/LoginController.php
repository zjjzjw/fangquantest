<?php

namespace App\Web\Http\Controllers\Api\Account;


use App\Src\FqUser\Domain\Model\FqUserEntity;
use App\Src\FqUser\Infra\Repository\FqUserRepository;
use App\Src\Role\Domain\Model\UserEntity;
use App\Web\Http\Controllers\BaseController;
use App\Web\Service\Account\AccountService;
use App\Web\Src\Forms\Account\LoginForm;
use App\Web\Src\Forms\Account\ModifyNickNameForm;
use App\Web\Src\Forms\Account\ModifyPasswordForm;
use Illuminate\Http\Request;

class LoginController extends BaseController
{

    /**
     * 登录
     * @param Request   $request
     * @param LoginForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request, LoginForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $account_service = new AccountService();
        $result = $account_service->login($form->login_specification);
        \Auth::loginUsingId($result['user_id']);
        $fq_user_repository = new FqUserRepository();
        /** @var UserEntity $user_entity */
        $user_entity = $fq_user_repository->fetch($result['user_id']);
        if (isset($user_entity)) {
            $data = $user_entity->toArray();
        }
        return response()->json($data, 200);
    }

    /**
     * 修改密码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function modifyPassword(Request $request, ModifyPasswordForm $form)
    {
        $data = [];
        $user_id = $request->user()->id;
        $form->validate($request->all());
        /** @var FqUserEntity $fq_user_entity */
        $fq_user_repository = new FqUserRepository();
        $fq_user_entity = $fq_user_repository->fetch($user_id);
        $fq_user_entity->password = $form->password;
        $fq_user_repository->updatePassword($fq_user_entity);
        //退出登录
        \Auth::logout();
        return response()->json($data, 200);
    }


    public function modifyNickName(Request $request, ModifyNickNameForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $user_id = request()->user()->id;
        $fq_user_repository = new FqUserRepository();
        /** @var FqUserEntity $fq_user_entity */
        $fq_user_entity = $fq_user_repository->fetch($user_id);
        if (isset($fq_user_entity)) {
            $fq_user_entity->nickname = $form->nickname;
            $fq_user_repository->save($fq_user_entity);
        }
        return response()->json($data, 200);

    }


}


