<?php namespace App\Admin\Http\Controllers\Msg;


use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Msg\UserMsg\UserMsgSearchForm;
use App\Service\Msg\UserMsgService;
use App\Src\Msg\Domain\Model\UserMsgSpecification;
use Illuminate\Http\Request;


class UserMsgController extends BaseController
{
    public function index(Request $request, UserMsgSearchForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $user_msg_service = new UserMsgService();
        $data = $user_msg_service->getUserMsgList($form->user_msg_specification, 20);
        $appends = $this->getAppends($form->user_msg_specification);
        $data['appends'] = $appends;
        return $this->view('pages.msg.user-msg.index', $data);
    }

    public function send(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $user_msg_service = new UserMsgService();
            $data = $user_msg_service->getUserMsgInfo($id);
        }
        return $this->view('pages.msg.user-msg.send', $data);
    }

    public function getAppends(UserMsgSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }

        return $appends;
    }

}
