<?php

namespace App\Web\Http\Controllers\Personal;

use App\Service\FqUser\FqUserService;
use App\Service\Provider\ProviderProductProgrammeService;
use App\Src\Developer\Domain\Model\DeveloperProjectSpecification;
use App\Src\Developer\Domain\Model\DeveloperProjectStatus;
use App\Src\FqUser\Domain\Model\FqUserEntity;
use App\Src\FqUser\Infra\Repository\FqUserRepository;
use App\Src\Provider\Domain\Model\ProviderProductProgrammeSpecification;
use App\Src\Provider\Domain\Model\ProviderProductProgrammeStatus;
use App\Src\Provider\Domain\Model\ProviderProductSpecification;
use App\Src\Provider\Domain\Model\ProviderProductStatus;
use App\Src\Provider\Domain\Model\ProviderSpecification;
use App\Src\Provider\Domain\Model\ProviderStatus;
use App\Web\Http\Controllers\BaseController;
use App\Web\Service\Account\AccountService;
use App\Web\Service\Developer\DeveloperProjectWebService;
use App\Web\Service\Developer\UserFavoriteWebService;
use App\Web\Service\Provider\ProviderProductWebService;
use App\Web\Service\Provider\ProviderWebService;
use App\Web\Src\Forms\Developer\DeveloperProject\DeveloperProjectSearchForm;
use App\Web\Src\Forms\Provider\ProviderProductProgrammeSearchForm;
use App\Web\Src\Forms\Provider\ProviderProductSearchForm;
use App\Web\Src\Forms\Provider\ProviderSearchForm;
use Illuminate\Http\Request;

class CollectionController extends BaseController
{
    //收藏项目
    public function collectionProject(Request $request, DeveloperProjectSearchForm $form)
    {
        $data = [];
        $developer_project_web_service = new DeveloperProjectWebService();
        $request->merge([
            'user_id' => $request->user()->id,
            'status'  => DeveloperProjectStatus::YES,
        ]);
        $form->validate($request->all());
        $data = $developer_project_web_service->getDeveloperProjectList($form->developer_project_specification, 20);

        //账户信息
        $user_id = $request->user()->id;
        $fq_user_repository = new FqUserRepository();
        /** @var FqUserEntity $fq_user_entity */
        $fq_user_entity = $fq_user_repository->fetch($user_id);
        $account_service = new AccountService();
        $account_info = $account_service->getAccountInfo($fq_user_entity);
        $data['account_info'] = $account_info;
        $fq_user_service = new FqUserService();
        $data['fq_user_info'] = $fq_user_service->getFqUserInfoById($fq_user_entity->id);

        $user_favorite_web_service = new UserFavoriteWebService();
        $data['count'] = $user_favorite_web_service->getUserFavoriteCount($request->user()->id);

        $appends = $this->getDeveloperProjectAppends($form->developer_project_specification);
        $data['appends'] = $appends;
        return $this->view('pages.personal.collection.collection-project', $data);
    }

    //收藏供应商
    public function collectionProvider(Request $request, ProviderSearchForm $form)
    {
        $data = [];
        $provider_web_service = new ProviderWebService();
        $request->merge([
            'user_id' => $request->user()->id,
            'status'  => ProviderStatus::YES_CERTIFIED,
        ]);
        $form->validate($request->all());
        $data = $provider_web_service->getProviderList($form->provider_specification, 20);


        //账户信息
        $user_id = $request->user()->id;
        $fq_user_repository = new FqUserRepository();
        /** @var FqUserEntity $fq_user_entity */
        $fq_user_entity = $fq_user_repository->fetch($user_id);
        $account_service = new AccountService();
        $account_info = $account_service->getAccountInfo($fq_user_entity);
        $data['account_info'] = $account_info;
        $fq_user_service = new FqUserService();
        $data['fq_user_info'] = $fq_user_service->getFqUserInfoById($fq_user_entity->id);

        $user_favorite_web_service = new UserFavoriteWebService();
        $data['count'] = $user_favorite_web_service->getUserFavoriteCount($request->user()->id);
        $appends = $this->getProviderAppends($form->provider_specification);
        $data['appends'] = $appends;

        return $this->view('pages.personal.collection.collection-provider', $data);
    }

    //收藏产品
    public function collectionProduct(Request $request, ProviderProductSearchForm $form)
    {
        $data = [];
        $provider_product_web_service = new ProviderProductWebService();
        $request->merge([
            'user_id' => $request->user()->id,
            'status'  => ProviderProductStatus::STATUS_PASS,
        ]);
        $form->validate($request->all());
        $data = $provider_product_web_service->getProviderProductList($form->provider_product_specification, 20);


        //账户信息
        $user_id = $request->user()->id;
        $fq_user_repository = new FqUserRepository();
        /** @var FqUserEntity $fq_user_entity */
        $fq_user_entity = $fq_user_repository->fetch($user_id);
        $account_service = new AccountService();
        $account_info = $account_service->getAccountInfo($fq_user_entity);
        $data['account_info'] = $account_info;
        $fq_user_service = new FqUserService();
        $data['fq_user_info'] = $fq_user_service->getFqUserInfoById($fq_user_entity->id);

        $appends = $this->getProviderProductAppends($form->provider_product_specification);

        $data['search_categories'] = $provider_product_web_service->getProductCategoryByUserId(
            $request->user()->id, ProviderProductStatus::STATUS_PASS
        );
        $user_favorite_web_service = new UserFavoriteWebService();
        $data['count'] = $user_favorite_web_service->getUserFavoriteCount($request->user()->id);
        $data['appends'] = $appends;
        return $this->view('pages.personal.collection.collection-product', $data);
    }


    //收藏方案
    public function collectionScheme(Request $request, ProviderProductProgrammeSearchForm $form)
    {
        $data = [];
        $request->merge([
            'user_id' => $request->user()->id,
            'status'  => ProviderProductProgrammeStatus::STATUS_PASS,
        ]);
        $form->validate($request->all());
        $provider_product_programme_service = new ProviderProductProgrammeService();
        $data = $provider_product_programme_service->getProviderProductProgrammeList($form->provider_product_programme_specification, 20);

        //账户信息
        $user_id = $request->user()->id;
        $fq_user_repository = new FqUserRepository();
        /** @var FqUserEntity $fq_user_entity */
        $fq_user_entity = $fq_user_repository->fetch($user_id);
        $account_service = new AccountService();
        $account_info = $account_service->getAccountInfo($fq_user_entity);
        $data['account_info'] = $account_info;
        $fq_user_service = new FqUserService();
        $data['fq_user_info'] = $fq_user_service->getFqUserInfoById($fq_user_entity->id);

        $user_favorite_web_service = new UserFavoriteWebService();
        $data['count'] = $user_favorite_web_service->getUserFavoriteCount($request->user()->id);
        $appends = $this->getProgrammeAppends($form->provider_product_programme_specification);
        $data['appends'] = $appends;
        return $this->view('pages.personal.collection.collection-scheme', $data);
    }

    public function getDeveloperProjectAppends(DeveloperProjectSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }

    public function getProviderAppends(ProviderSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }

    public function getProgrammeAppends(ProviderProductProgrammeSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }

    public function getProviderProductAppends(ProviderProductSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }

        if ($spec->second_product_category_id) {
            $appends['second_product_category_id'] = $spec->second_product_category_id;
        }
        return $appends;
    }
}