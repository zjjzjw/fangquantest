<?php

namespace App\Web\Http\Controllers\Api\FqUser;

use App\Src\FqUser\Infra\Repository\FqUserFeedbackRepository;
use App\Web\Http\Controllers\BaseController;
use App\Web\Src\Forms\FqUser\FqUserFeedback\FqUserFeedbackStoreForm;
use Illuminate\Http\Request;

class FqUserFeedbackController extends BaseController
{
    public function store(Request $request, FqUserFeedbackStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $fq_user_feedback_repository = new FqUserFeedbackRepository();
        $fq_user_feedback_repository->save($form->fq_user_feedback_entity);
        return response()->json($data, 200);
    }

}


