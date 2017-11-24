<?php namespace App\Admin\Http\Controllers\Api\Msg;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Msg\UserMsg\UserMsgDeleteForm;
use App\Admin\Src\Forms\Msg\UserMsg\UserMsgStoreForm;
use App\Src\Msg\Infra\Repository\UserMsgRepository;
use Illuminate\Http\Request;


class UserMsgController extends BaseController
{
    public function store(Request $request, UserMsgStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());

        $user_msg_repository = new UserMsgRepository();
        $user_msg_repository->save($form->user_msg_entity);

        $data['id'] = $form->user_msg_entity->id;
        return response()->json($data, 200);
    }


    public function update(Request $request, UserMsgStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }


    public function delete(Request $request, UserMsgDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $user_msg_repository = new UserMsgRepository();
        $user_msg_repository->delete($id);

        return response()->json($data, 200);
    }
}