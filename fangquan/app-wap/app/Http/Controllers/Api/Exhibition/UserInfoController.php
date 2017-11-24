<?php
namespace App\Wap\Http\Controllers\Api\Exhibition;

use App\Service\FqUser\FqUserService;
use App\Src\Content\Infra\Repository\UserInfoRepository;
use App\Wap\Src\Forms\UserInfo\UserInfoStoreForm;
use App\Wap\Src\Forms\UserInfo\UserInfoDeleteForm;
use App\Web\Http\Controllers\BaseController;
use Illuminate\Http\Request;


class UserInfoController extends BaseController
{
    /**
     * 添加
     * @param Request                $request
     * @param UserInfoStoreForm    $form
     * @param                        $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, UserInfoStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $user_info_repository = new UserInfoRepository();
        $user_info_repository->save($form->user_info_entity);

        $fq_user_service = new FqUserService();
        $fq_user_service->saveUserInfo($form->user_info_entity);
        $data['id'] = $form->user_info_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改
     * @param Request                  $request
     * @param UserInfoStoreForm      $form
     * @param                          $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, UserInfoStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除
     * @param Request                    $request
     * @param UserInfoDeleteForm       $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, UserInfoDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $user_info_repository = new UserInfoRepository();
        $user_info_repository->delete($id);
        return response()->json($data, 200);
    }
}

