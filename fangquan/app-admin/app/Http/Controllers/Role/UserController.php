<?php

namespace App\Admin\Http\Controllers\Role;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Role\User\UserSearchForm;
use App\Service\Role\RoleService;
use App\Service\Role\UserService;
use App\Src\Role\Domain\Model\UserSpecification;
use Illuminate\Http\Request;

class UserController extends BaseController
{

    public function index(Request $request, UserSearchForm $form)
    {
        $data = [];
        $user_service = new UserService();
        $form->validate($request->all());
        $data = $user_service->getUserList($form->user_specification, 20);

        $appends = $this->getAppends($form->user_specification);
        $data['appends'] = $appends;
        return $this->view('pages.role.user.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $data = [];
        $user_service = new UserService();
        if (!empty($id)) {
            $data = $user_service->getUserInfoById($id);
        }
        $role_service = new RoleService();
        $data['role_list'] = $role_service->getUserRoleList();
        return $this->view('pages.role.user.edit', $data);
    }


    public function setPassword(Request $request, $id)
    {
        $data = [];
        $data['id'] = $id;
        return $this->view('pages.role.user.set-password', $data);
    }

    public function getAppends(UserSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }
}


