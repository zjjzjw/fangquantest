<?php

namespace App\Web\Http\Controllers\Personal;

use App\Service\FqUser\FqUserService;
use App\Src\FqUser\Domain\Model\FqUserEntity;
use App\Src\FqUser\Domain\Model\FqUserRegisterType;
use App\Src\FqUser\Domain\Model\FqUserRoleType;
use App\Src\FqUser\Infra\Repository\FqUserRepository;
use App\Web\Http\Controllers\BaseController;
use App\Web\Service\Account\AccountService;
use Illuminate\Http\Request;


class AccountInfoController extends BaseController
{

    public function index(Request $request)
    {
        $data = [];
        $user_id = $request->user()->id;
        $fq_user_repository = new FqUserRepository();
        /** @var FqUserEntity $fq_user_entity */
        $fq_user_entity = $fq_user_repository->fetch($user_id);
        $account_service = new AccountService();
        $account_info = $account_service->getAccountInfo($fq_user_entity);
        $data['account_info'] = $account_info;
        $fq_user_service = new FqUserService();
        $data['fq_user_info'] = $fq_user_service->getFqUserInfoById($fq_user_entity->id);
        return $this->view('pages.personal.account.account-info', $data);
    }


}