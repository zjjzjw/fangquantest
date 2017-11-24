<?php

namespace App\Web\Http\Controllers\Personal;

use App\Src\Msg\Domain\Model\UserMsgSpecification;
use App\Web\Src\Forms\Msg\UserMsg\UserMsgSearchForm;
use App\Service\Msg\UserMsgService;
use App\Src\FqUser\Domain\Model\FqUserEntity;
use App\Src\FqUser\Infra\Repository\FqUserRepository;
use App\Web\Http\Controllers\BaseController;
use App\Web\Service\Account\AccountService;
use Illuminate\Http\Request;


class MessageController extends BaseController
{

    public function index(Request $request, UserMsgSearchForm $form)
    {

        $data = [];
        $user_id = $request->user()->id;
        $request->merge(['to_uid' => $user_id]);
        $form->validate($request->all());
        $fq_user_repository = new FqUserRepository();
        /** @var FqUserEntity $fq_user_entity */
        $fq_user_entity = $fq_user_repository->fetch($user_id);
        $account_service = new AccountService();
        $account_info = $account_service->getAccountInfo($fq_user_entity);
        $data['account_info'] = $account_info;
        //得到消息列表
        $user_msg_service = new UserMsgService();
        $user_msg_list = $user_msg_service->getUserMsgList($form->user_msg_specification, 20);
        $data['user_msg_list'] = $user_msg_list;
        $data['appends'] = $this->getAppends($form->user_msg_specification);
        return $this->view('pages.personal.message.list', $data);
    }

    public function getAppends(UserMsgSpecification $spec)
    {
        $appends = [];

        return $appends;
    }

}