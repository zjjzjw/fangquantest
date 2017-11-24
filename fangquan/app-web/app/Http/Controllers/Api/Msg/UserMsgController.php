<?php

namespace App\Web\Http\Controllers\Api\Msg;

use App\Src\Msg\Domain\Model\MsgStatus;
use App\Src\Msg\Domain\Model\UserMsgEntity;
use App\Src\Msg\Infra\Repository\UserMsgRepository;
use App\Web\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class UserMsgController extends BaseController
{
    public function setRead(Request $request, $msg_id)
    {
        $data = [];
        $user_msg_repository = new UserMsgRepository();
        /** @var UserMsgEntity $user_msg_entity */
        $user_msg_entity = $user_msg_repository->fetch($msg_id);
        if (isset($user_msg_entity)) {
            $user_msg_entity->status = MsgStatus::HAS_READ;
            $user_msg_repository->save($user_msg_entity);
        }
        return response()->json($data, 200);
    }

}


