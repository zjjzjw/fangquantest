<?php

namespace App\Admin\Http\Controllers\FqUser;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\FqUser\FqUserFeedback\FqUserFeedbackSearchForm;
use App\Service\FqUser\FqUserFeedbackService;
use App\Service\FqUser\FqUserService;
use App\Src\FqUser\Domain\Model\FqUserFeedbackSpecification;
use Illuminate\Http\Request;

class FqUserFeedbackController extends BaseController
{

    public function index(Request $request, FqUserFeedbackSearchForm $form)
    {
        $data = [];
        $fq_user_feedback_service = new FqUserFeedbackService();
        $form->validate($request->all());
        $data = $fq_user_feedback_service->getFqUserFeedbackList($form->fq_user_feedback_specification, 20);

        $appends = $this->getAppends($form->fq_user_feedback_specification);
        $data['appends'] = $appends;

        return $this->view('pages.fq-user.fq-user-feedback.index', $data);

    }

    public function edit(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $fq_user_feedback_service = new FqUserFeedbackService();
            $data = $fq_user_feedback_service->getFqUserFeedbackInfoById($id);
        }

        return $this->view('pages.fq-user.fq-user-feedback.edit', $data);
    }


    //设置密码
    public function setPassword(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $fq_user_service = new FqUserService();
            $data = $fq_user_service->getFqUserInfoById($id);
        }

        return $this->view('pages.fq-user.fq-user.set-password', $data);
    }


    public function getAppends(FqUserFeedbackSpecification $spec)
    {
        $appends = [];

        return $appends;
    }
}


