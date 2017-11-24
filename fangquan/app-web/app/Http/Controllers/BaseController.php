<?php

namespace App\Web\Http\Controllers;

use App\Service\Msg\UserMsgService;

class BaseController extends Controller
{
    protected function view($view, $data = array())
    {
        $data = array_merge(
            [
                'basic_data' => [
                    'user'       => request()->user(),
                    'login_info' => $this->getLoginInfo(),
                ],
            ],
            $data
        );
        return view($view, $data);
    }

    public function getLoginInfo()
    {
        $user_info = [];
        if (request()->user()) {
            $user_info = request()->user()->toArray();
            $user_msg_service = new UserMsgService();
            $user_info['msg_unread_count'] = $user_msg_service->getUnreadMsgCount(request()->user()->id);
        }
        return $user_info;
    }


}


