<?php namespace App\Admin\Http\Controllers\Api\FqUser;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\FqUser\FqUserFeedback\FqUserFeedbackDeleteForm;
use App\Src\FqUser\Domain\Model\FqUserFeedbackEntity;
use App\Src\FqUser\Domain\Model\FqUserFeedbackStatus;
use App\Src\FqUser\Infra\Repository\FqUserFeedbackRepository;
use Illuminate\Http\Request;

class FqUserFeedbackController extends BaseController
{
    public function delete(Request $request, FqUserFeedbackDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $fq_user_feedback_repository = new FqUserFeedbackRepository();
        $fq_user_feedback_repository->delete($id);

        return response()->json($data, 200);
    }

    public function audit(Request $request, $id)
    {
        $data = [];
        $fq_user_feedback_repository = new FqUserFeedbackRepository();
        /** @var FqUserFeedbackEntity $fq_user_feedback_entity */
        $fq_user_feedback_entity = $fq_user_feedback_repository->fetch($id);
        $fq_user_feedback_entity->status = FqUserFeedbackStatus::NOT_HANDLE;
        $fq_user_feedback_repository->save($fq_user_feedback_entity);
        return response()->json($data, 200);
    }


    public function reject(Request $request, $id)
    {
        $data = [];
        $fq_user_feedback_repository = new FqUserFeedbackRepository();
        /** @var FqUserFeedbackEntity $fq_user_feedback_entity */
        $fq_user_feedback_entity = $fq_user_feedback_repository->fetch($id);
        $fq_user_feedback_entity->status = FqUserFeedbackStatus::HANDLE;
        $fq_user_feedback_repository->save($fq_user_feedback_entity);
        return response()->json($data, 200);
    }
}