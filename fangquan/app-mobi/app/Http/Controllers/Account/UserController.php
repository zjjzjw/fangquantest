<?php

namespace App\Mobi\Http\Controllers\Account;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Src\Forms\Account\UserFeedbackStoreForm;
use App\Src\Role\Infra\Repository\UserFeedbackRepository;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function feedback(Request $request, UserFeedbackStoreForm $form)
    {
        $data = [];
        $result = [];
        $form->validate($request->all());
        $user_feedback_repository = new UserFeedbackRepository();
        $user_feedback_repository->save($form->user_feedback_entity);
        $result['success'] = true;
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $result;
        return response()->json($data, 200);
    }

}


