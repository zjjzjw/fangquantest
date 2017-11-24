<?php namespace App\Admin\Http\Controllers\Api\Role;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Role\Role\RoleDeleteForm;
use App\Admin\Src\Forms\Role\Role\RoleStoreForm;
use App\Src\Role\Infra\Repository\RoleRepository;
use Illuminate\Http\Request;

class RoleController extends BaseController
{

    /**
     * 添加角色
     * @param Request       $request
     * @param RoleStoreForm $form
     * @param               $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, RoleStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());

        $role_repository = new RoleRepository();
        $role_repository->save($form->role_entity);


        $data['id'] = $form->role_entity->id;
        return response()->json($data, 200);

    }


    /**
     * 更新角色
     * @param Request       $request
     * @param RoleStoreForm $form
     * @param               $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, RoleStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除角色
     * @param Request        $request
     * @param RoleDeleteForm $form
     * @param                $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, RoleDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $role_repository = new RoleRepository();
        $role_repository->delete($id);

        return response()->json($data, 200);
    }

}