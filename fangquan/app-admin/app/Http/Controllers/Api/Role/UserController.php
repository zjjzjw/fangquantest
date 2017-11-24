<?php namespace App\Admin\Http\Controllers\Api\Role;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Role\User\UserDeleteForm;
use App\Admin\Src\Forms\Role\User\UserStoreForm;
use App\Src\Role\Domain\Model\UserEntity;
use App\Src\Role\Infra\Repository\UserRepository;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * 添加用户
     * @param Request                  $request
     * @param UserStoreForm            $form
     * @param                          $id
     */
    public function store(Request $request, UserStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $user_repository = new UserRepository();
        $user_repository->save($form->user_entity);
        $data['id'] = $form->user_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改用户信息
     * @param Request                  $request
     * @param UserStoreForm            $form
     * @param                          $id
     */
    public function update(Request $request, UserStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除用户
     * @param Request                    $request
     * @param UserDeleteForm             $form
     * @param                            $id
     */
    public function delete(Request $request, UserDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $stock_repository = new UserRepository();
        $stock_repository->delete($id);

        return response()->json($data, 200);
    }


    /**
     * @param Request $request
     * @param int     $id
     */
    public function setPassword(Request $request, $id)
    {
        $data = [];
        $user_repository = new UserRepository();
        /** @var UserEntity $user_entity */
        $user_entity = $user_repository->fetch($id);
        $user_entity->password = $request->get('password');


        $user_repository->updatePassword($user_entity);

        return response()->json($data, 200);
    }

}
