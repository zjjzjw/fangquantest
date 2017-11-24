<?php namespace App\Admin\Http\Controllers\Msg;


use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Msg\BroadcastMsg\BroadcastMsgSearchForm;
use App\Service\Msg\BroadcastMsgService;
use App\Src\Msg\Domain\Model\BroadcastMsgSpecification;
use Illuminate\Http\Request;


class BroadcastMsgController extends BaseController
{
    public function index(Request $request, BroadcastMsgSearchForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $user_msg_service = new BroadcastMsgService();
        $data = $user_msg_service->getBroadcastMsgList($form->broadcast_msg_specification, 20);
        $appends = $this->getAppends($form->broadcast_msg_specification);
        $data['appends'] = $appends;
        return $this->view('pages.msg.broadcast-msg.index', $data);
    }

    public function send(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $user_msg_service = new BroadcastMsgService();
            $data = $user_msg_service->getBroadcastMsgInfo($id);
        }
        return $this->view('pages.msg.broadcast-msg.send', $data);
    }

    public function getAppends(BroadcastMsgSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }

        return $appends;
    }

}
