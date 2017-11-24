<?php namespace App\Admin\Http\Controllers\Api\Msg;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Msg\BroadcastMsg\BroadcastMsgDeleteForm;
use App\Admin\Src\Forms\Msg\BroadcastMsg\BroadcastMsgStoreForm;
use App\Src\Msg\Infra\Repository\BroadcastMsgRepository;
use Illuminate\Http\Request;


class BroadcastMsgController extends BaseController
{
    public function store(Request $request, BroadcastMsgStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());

        $broadcast_msg_repository = new BroadcastMsgRepository();
        $broadcast_msg_repository->save($form->broadcast_msg_entity);

        $data['id'] = $form->broadcast_msg_entity->id;
        return response()->json($data, 200);
    }


    public function update(Request $request, BroadcastMsgStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }


    public function delete(Request $request, BroadcastMsgDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $broadcast_msg_repository = new BroadcastMsgRepository();
        $broadcast_msg_repository->delete($id);

        return response()->json($data, 200);
    }
}