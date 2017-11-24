<?php

namespace App\Admin\Http\Controllers\FqUser;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\FqUser\FqUser\FqUserSearchForm;
use App\Service\FqUser\FqUserService;
use App\Src\FqUser\Domain\Model\FqUserAccountType;
use App\Src\FqUser\Domain\Model\FqUserPermissionProjectAreaType;
use App\Src\FqUser\Domain\Model\FqUserPermissionProjectCategoryType;
use App\Src\FqUser\Domain\Model\FqUserPlatformType;
use App\Src\FqUser\Domain\Model\FqUserRoleType;
use App\Src\FqUser\Domain\Model\FqUserSpecification;
use App\Src\FqUser\Domain\Model\FqUserStatus;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use Illuminate\Http\Request;

class FqUserController extends BaseController
{

    public function index(Request $request, FqUserSearchForm $form)
    {
        $data = [];
        $fq_user_service = new FqUserService();
        $form->validate($request->all());
        $data = $fq_user_service->getFqUserList($form->fq_user_specification, 20);

        $appends = $this->getAppends($form->fq_user_specification);
        $data['appends'] = $appends;
        $data['account_type_enums'] = FqUserAccountType::acceptableEnums();
        $data['account_platform_enums'] = FqUserPlatformType::acceptableEnums();
        return $this->view('pages.fq-user.fq-user.index', $data);

    }

    public function edit(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $fq_user_service = new FqUserService();
            $data = $fq_user_service->getFqUserInfoById($id);
        }
        $data['project_category_enums'] = FqUserPermissionProjectCategoryType::acceptableEnums();
        $data['project_area_enums'] = FqUserPermissionProjectAreaType::acceptableEnums();
        $data['account_type_enums'] = FqUserAccountType::acceptableEnums();
        $data['role_type_enums'] = FqUserRoleType::acceptableEnums();
        $data['status_type_enums'] = FqUserStatus::acceptableEnums();

        return $this->view('pages.fq-user.fq-user.edit', $data);
    }

    public function bind(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $fq_user_service = new FqUserService();
            $data = $fq_user_service->getFqUserInfoById($id);
        }
        $data['fq_user_role_type'] = FqUserRoleType::acceptableEnums();
        return $this->view('pages.fq-user.fq-user.bind', $data);
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


    public function getAppends(FqUserSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        if ($spec->account_type) {
            $appends['account_type'] = $spec->account_type;
        }
        if ($spec->platform_id) {
            $appends['platform_id'] = $spec->platform_id;
        }
        if ($spec->provider_id) {
            $appends['company_id'] = $spec->provider_id;
            $provider_repository = new ProviderRepository();
            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($spec->provider_id);
            if (isset($provider_entity)) {
                $appends['company_name'] = $provider_entity->company_name;
            }
        }
        return $appends;
    }
}


