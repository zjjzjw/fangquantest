<?php

namespace App\Web\Http\Controllers\Developer;

use App\Service\Advertisement\AdvertisementService;
use App\Service\Developer\DeveloperProjectContactService;
use App\Src\Advertisement\Domain\Model\AdvertisementType;
use App\Src\Developer\Domain\Model\DeveloperProjectAdType;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use App\Web\Src\Forms\Developer\DeveloperProject\DeveloperProjectSearchForm;
use App\Service\Developer\DeveloperProjectService;
use App\Src\Developer\Domain\Model\DeveloperProjectSpecification;
use App\Web\Service\Developer\DeveloperProjectStageWebService;
use App\Src\Developer\Domain\Model\DeveloperProjectStatus;
use App\Web\Service\Developer\DeveloperProjectWebService;
use App\Web\Service\Developer\ProductCategoryWebService;
use App\Web\Src\Forms\Developer\DeveloperSearchForm;
use App\Src\Developer\Domain\Model\DeveloperType;
use App\Web\Service\Surport\ChinaAreaWebService;
use App\Web\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class DeveloperProjectController extends BaseController
{
    /**
     * 项目列表
     * @param Request                    $request
     * @param DeveloperProjectSearchForm $form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, DeveloperProjectSearchForm $form)
    {
        $data = [];
        $request->merge(['status' => DeveloperProjectStatus::YES]);
        $request->merge(['developer_type' => DeveloperType::TOP_HUNDRED]);
        $request->merge(['is_ad' => DeveloperProjectAdType::NO]);
        $form->validate($request->all());

        $developer_project_web_service = new DeveloperProjectWebService();
        $product_category_web_service = new ProductCategoryWebService();
        $developer_project_stage_service = new DeveloperProjectStageWebService();
        $china_area_service = new ChinaAreaWebService();
        $developer_project_service = new DeveloperProjectService();

        $data = $developer_project_web_service->getDeveloperProjectList($form->developer_project_specification, 10);
        $data['china_areas'] = $china_area_service->getChinaAreaWithProvince();

        $data['developer_project_stages'] = $developer_project_stage_service->getDeveloperProjectStageList();
        $data['product_categories'] = $product_category_web_service->getSearchProductCategories();
        $data['ad_developer_projects'] = $developer_project_service->getAdDeveloperProjectList(
            DeveloperProjectStatus::YES, 10
        );
        $data['appends'] = $this->getAppends($form->developer_project_specification);

        return $this->view('pages.developer.developer-project.list', $data);
    }

    public function detail(Request $request, DeveloperSearchForm $form, $developer_project_id)
    {
        $data = [];
        $developer_project_web_service = new DeveloperProjectWebService();
        $developer_project_service = new DeveloperProjectService();
        $data = $developer_project_web_service->getDeveloperProjectInfo($developer_project_id);
        $data['ad_developer_projects'] = $developer_project_service->getAdDeveloperProjectList(
            DeveloperProjectStatus::YES, 10
        );
        if ($request->user()) {
            $developer_project_web_service->setProjectBrowseRecord($request->user()->id, $developer_project_id);
        }
        return $this->view('pages.developer.developer-project.detail', $data);
    }

    public function getAppends(DeveloperProjectSpecification $spec)
    {
        $appends = [];
        $appends['product_category_id'] = $spec->product_category_id ? (string)$spec->product_category_id : 0;
        $appends['province_id'] = $spec->province_id ? (string)$spec->province_id : 0;
        $appends['project_stage_id'] = $spec->project_stage_id ? (string)$spec->project_stage_id : 0;

        if ($spec->province_id) {
            $province_repository = new ProvinceRepository();
            /** @var ProvinceEntity $province_entity */
            $province_entity = $province_repository->fetch($spec->province_id);
            if (isset($province_entity)) {
                $appends['china_area_id'] = $province_entity->area_id;
                $appends['province_name'] = $province_entity->name;
            }
        }

        if ($spec->column) {
            $appends['column'] = $spec->column;
        } else {
            $appends['column'] = 'updated_at';
        }

        if ($spec->sort) {
            $appends['sort'] = $spec->sort;
        } else {
            $appends['sort'] = 'desc';
        }

        if ($spec->keyword) {
            $appends['keyword'] = (string)$spec->keyword;
        }

        if ($spec->developer_id) {
            $appends['developer_id'] = $spec->developer_id;
        }

        return $appends;
    }


}