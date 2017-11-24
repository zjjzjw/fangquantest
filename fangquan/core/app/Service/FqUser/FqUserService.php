<?php namespace App\Service\FqUser;

use App\Src\Content\Domain\Model\UserInfoEntity;
use App\Src\Developer\Domain\Model\DeveloperEntity;
use App\Src\Developer\Infra\Repository\DeveloperRepository;
use App\Src\FqUser\Domain\Model\FqUserAccountType;
use App\Src\FqUser\Domain\Model\FqUserEntity;
use App\Src\FqUser\Domain\Model\FqUserPlatformType;
use App\Src\FqUser\Domain\Model\FqUserRoleType;
use App\Src\FqUser\Domain\Model\FqUserSpecification;
use App\Src\FqUser\Domain\Model\FqUserStatus;
use App\Src\FqUser\Infra\Repository\FqUserRepository;
use App\Src\Provider\Domain\Model\ProviderAdType;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use phpDocumentor\Reflection\Types\Null_;

class FqUserService
{
    /**
     * @param FqUserSpecification $spec
     * @param int                 $per_page
     * @return array
     */
    public function getFqUserList(FqUserSpecification $spec, $per_page = 20)
    {
        $data = [];
        $fq_user_repository = new FqUserRepository();
        $paginate = $fq_user_repository->search($spec, $per_page);

        $items = [];

        /**
         * @var int                  $key
         * @var FqUserEntity         $fq_user_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $fq_user_entity) {
            $item = $fq_user_entity->toArray();

            $item['company_name'] = $this->getFqUserCompanyName($fq_user_entity->role_id, $fq_user_entity->role_type);

            $platform_types = FqUserPlatformType::acceptableEnums();
            $account_types = FqUserAccountType::acceptableEnums();
            $role_types = FqUserRoleType::acceptableEnums();
            $status = FqUserStatus::acceptableEnums();
            $item['platform_type_name'] = $platform_types[$fq_user_entity->platform_id] ?? '';
            $item['account_type_name'] = $account_types[$fq_user_entity->account_type] ?? '';
            $item['role_type_name'] = $role_types[$fq_user_entity->role_type] ?? '';
            $item['status_name'] = $status[$fq_user_entity->status] ?? '';

            $items[] = $item;
        }

        $data['paginate'] = $paginate;
        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();

        return $data;
    }


    /**
     * @param $id
     * @return array
     */
    public function getFqUserInfoById($id)
    {
        $data = [];
        $fq_user_repository = new FqUserRepository();
        /** @var FqUserEntity $fq_user_entity */
        $fq_user_entity = $fq_user_repository->fetch($id);
        if (isset($fq_user_entity)) {
            $data = $fq_user_entity->toArray();

            $data['company_name'] = $this->getFqUserCompanyName($fq_user_entity->role_id, $fq_user_entity->role_type);

            if (isset($fq_user_entity->project_area)) {
                $data['project_area_array'] = explode(',', $fq_user_entity->project_area);
            }
            if (isset($fq_user_entity->project_category)) {
                $data['project_category_array'] = explode(',', $fq_user_entity->project_category);
            }
        }
        return $data;
    }

    /**
     * 根据role_id查找企业信息
     * @param     $role_id
     * @param int $role_type
     * @return ProviderEntity|DeveloperEntity|null|string
     */
    public function getFqUserCompanyByRoleId($role_id, $role_type)
    {
        if (intval($role_type) === FqUserRoleType::PROVIDER) {
            $repository = new ProviderRepository();
        }
        if (intval($role_type) === FqUserRoleType::DEVELOPER) {
            $repository = new DeveloperRepository();
        }
        if (isset($repository)) {
            $entity = $repository->fetch($role_id);
        }

        return $entity ?? '';
    }

    /**
     * 根据role_id查找企业名称
     * @param $role_id
     * @param $role_type
     * @return string
     */
    public function getFqUserCompanyName($role_id, $role_type)
    {
        $entity = $this->getFqUserCompanyByRoleId($role_id, $role_type);
        $company_name = '';
        if (!empty($entity)) {
            switch (intval($role_type)) {
                case FqUserRoleType::PROVIDER :
                    $company_name = $entity->company_name;
                    break;
                case FqUserRoleType::DEVELOPER :
                    $company_name = $entity->name;
                    break;
                default:
                    $company_name = '';
                    break;
            }
        }

        return $company_name;
    }


    public function saveCompanyGetRoleId($role_type, $company_name)
    {
        $role_id = 0;
        if ($role_type == FqUserRoleType::PROVIDER) {
            $provider_entity = new ProviderEntity();
            $provider_entity->company_name = $company_name;
            $provider_entity->brand_name = '';
            $provider_entity->patent_count = 0;
            $provider_entity->favorite_count = 0;
            $provider_entity->product_count = 0;
            $provider_entity->project_count = 0;
            $provider_entity->province_id = 0;
            $provider_entity->city_id = 0;
            $provider_entity->operation_address = '';
            $provider_entity->produce_province_id = 0;
            $provider_entity->produce_city_id = 0;
            $provider_entity->produce_address = '';
            $provider_entity->telphone = '';
            $provider_entity->fax = '';
            $provider_entity->service_telphone = '';
            $provider_entity->website = '';
            $provider_entity->operation_mode = 0;
            $provider_entity->founding_time = 0;
            $provider_entity->turnover = 0;
            $provider_entity->registered_capital = 0.00;
            $provider_entity->worker_count = 0;
            $provider_entity->summary = '';
            $provider_entity->corp = '';
            $provider_entity->score_scale = 0;
            $provider_entity->score_qualification = 0;
            $provider_entity->score_credit = 0;
            $provider_entity->score_innovation = 0;
            $provider_entity->score_service = 0;
            $provider_entity->contact = '';
            $provider_entity->integrity = 0;
            $provider_entity->status = 0;
            $provider_entity->rank = 0;
            $provider_entity->is_ad = ProviderAdType::NO;
            $provider_entity->provider_pictures = '';
            $provider_entity->provider_main_category = '';
            $provider_entity->registered_capital_unit = '';

            $provider_repository = new ProviderRepository();
            $provider_repository->save($provider_entity);

            $role_id = $provider_entity->id;
        }

        if ($role_type == FqUserRoleType::DEVELOPER) {
            $developer_entity = new DeveloperEntity();
            $developer_entity->name = $company_name;
            $developer_entity->logo = 0;
            $developer_entity->status = 0;

            $developer_repository = new DeveloperRepository();
            $developer_repository->save($developer_entity);

            $role_id = $developer_entity->id;
        }


        return $role_id;
    }

    /**
     * @param UserInfoEntity $user_info
     */
    public function saveUserInfo($user_info)
    {
        if ($user_info->user_id) {
            $fq_user_repository = new FqUserRepository();
            /** @var FqUserEntity $fq_user_entity */
            $fq_user_entity = $fq_user_repository->fetch($user_info->user_id);
            $fq_user_entity->email = $user_info->email;
            $fq_user_entity->mobile = $user_info->phone;
            $fq_user_entity->nickname = $user_info->name;
            $fq_user_repository->save($fq_user_entity);
        }
    }
}