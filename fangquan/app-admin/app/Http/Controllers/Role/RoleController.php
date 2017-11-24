<?php namespace App\Admin\Http\Controllers\Role;


use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Role\Role\RoleSearchForm;
use App\Service\Role\RoleService;
use App\Src\Role\Domain\Model\RoleSpecification;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
    public function index(Request $request, RoleSearchForm $form)
    {
        $data = [];
        $role_service = new RoleService();
        $form->validate($request->all());
        $data = $role_service->getRoleList($form->role_specification, 20);

        $appends = $this->getAppends($form->role_specification);
        $data['appends'] = $appends;
        return $this->view('pages.role.role.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $data = [];
        $role_service = new RoleService();
        if (!empty($id)) {
            $data = $role_service->getRoleInfo($id);
        }
        $data['role_permissions'] = $role_service->getPermissions();
        return $this->view('pages.role.role.edit', $data);
    }

    public function getAppends(RoleSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }
}
