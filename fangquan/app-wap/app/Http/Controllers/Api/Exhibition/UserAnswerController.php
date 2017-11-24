<?php

namespace App\Wap\Http\Controllers\Api\Exhibition;

use App\Src\Content\Infra\Repository\UserAnswerRepository;
use App\Wap\Src\Forms\UserAnswer\UserAnswerStoreForm;
use App\Wap\Src\Forms\UserAnswer\UserAnswerDeleteForm;
use App\Web\Http\Controllers\BaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;


class UserAnswerController extends BaseController
{
    /**
     * 添加
     * @param Request                $request
     * @param UserAnswerStoreForm    $form
     * @param                        $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, UserAnswerStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $user_answer_repository = new UserAnswerRepository();
        $user_answer_repository->save($form->user_answer_entity);
        $data['id'] = $form->user_answer_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改
     * @param Request                  $request
     * @param UserAnswerStoreForm      $form
     * @param                          $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, UserAnswerStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除
     * @param Request                    $request
     * @param UserAnswerDeleteForm       $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, UserAnswerDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $user_answer_repository = new UserAnswerRepository();
        $user_answer_repository->delete($id);
        return response()->json($data, 200);
    }

    public function time()
    {
        $data = [];
        $start_time = '2017-10-29 11:40:00';
        $time = Carbon::now();
        if ($time > $start_time) {
            $data['success'] = true;
        } else {
            $data['success'] = false;
        }
        return response()->json($data, 200);
    }
}

