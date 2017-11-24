<?php

namespace App\Web\Http\Controllers\Exhibition;

use App\Service\Developer\DeveloperProjectService;
use App\Service\Developer\DeveloperService;
use App\Src\Developer\Domain\Model\DeveloperSpecification;
use App\Src\Developer\Domain\Model\DeveloperProjectBiddingType;
use App\Web\Http\Controllers\BaseController;
use App\Web\Service\Developer\DeveloperProjectWebService;
use App\Web\Src\Forms\Developer\DeveloperProject\DeveloperProjectSearchForm;
use App\Web\Src\Forms\Developer\DeveloperSearchForm;
use App\Src\Developer\Domain\Model\DeveloperProjectSpecification;
use App\Src\Developer\Domain\Model\DeveloperProjectStatus;
use App\Service\Project\ProjectCategoryService;
use App\Web\Service\Surport\ChinaAreaWebService;
use App\Src\Developer\Domain\Model\DeveloperType;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use App\Admin\Src\Forms\Project\ProjectCategorySearchForm;
use App\Src\Project\Domain\Model\ProjectCategorySpecification;
use App\Service\Regional\ChinaAreaService;
use App\Src\Developer\Domain\Model\DeveloperProjectAdType;
use App\Service\Regional\ProvinceService;
use App\Web\Service\Developer\ProductCategoryWebService;
use App\Web\Service\Developer\DeveloperProjectStageWebService;
use Illuminate\Http\Request;

class DeveloperController extends BaseController
{
    /**
     * 展会开发商列表
     * @param Request             $request
     * @param DeveloperSearchForm $form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function developerList(Request $request, DeveloperSearchForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $developer_service = new DeveloperService();
        $data = $developer_service->getDeveloperList($form->developer_specification, 20);
        $data['appends'] = $this->getDeveloperAppends($form->developer_specification);
        return $this->view('pages.exhibition.developer-list', $data);

    }

    //开发商项目列表
    public function developerProjectList(Request $request, DeveloperProjectSearchForm $form)
    {
        $data = [];
        $developer_project_service = new DeveloperProjectService();
        $request->merge(['status' => DeveloperProjectStatus::YES]);
        $request->merge(['is_ad' => DeveloperProjectAdType::NO]);

        $form->validate($request->all());

        //项目列表
        $data = $developer_project_service->getDeveloperProjectList($form->developer_project_specification, 20);
        $appends = $this->getDeveloperProjectListAppends($form->developer_project_specification);

        $data['appends'] = $appends;
        $data['developer_project_status'] = DeveloperProjectStatus::acceptableEnums();
        $data['developer_project_bidding_type'] = DeveloperProjectBiddingType::acceptableEnums();

        //项目品类树
        $project_category_service = new ProjectCategoryService();
        $data['project_main_category'] = $project_category_service->getAllDeveloperCategoryTreeList();

        //区域树
        $china_area_service = new ChinaAreaWebService();
        $data['china_areas'] = $china_area_service->getChinaAreaWithProvince();

        return $this->view('pages.exhibition.developer-project-list', $data);
    }


    public function developerDetail(Request $request, DeveloperSearchForm $form, $id)
    {
        $data = [];
        $developer_project_web_service = new DeveloperProjectWebService();
        $project = $developer_project_web_service->getDeveloperProjectInfo($id);

        $data['project'] = $project;
        return $this->view('pages.exhibition.developer.developer-detail', $data);
    }

    public function getDeveloperProjectListAppends(DeveloperProjectSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
         if ($spec->developer_id) {
             $appends['developer_id'] = $spec->developer_id;
         }
        if ($spec->bidding_type) {
            $appends['bidding_type'] = $spec->bidding_type;
        }
        if ($spec->project_category_id) {
            $appends['project_category_id'] = $spec->project_category_id;
        }
        if ($spec->status) {
            $appends['status'] = $spec->status;
        }
        //项目阶段
        if ($spec->project_stage_id) {
            $appends['project_stage_id'] = $spec->project_stage_id;
        }
        //项目类别
        if ($spec->project_category) {
            $appends['project_category'] = $spec->project_category;
        }
        //是否优选
        if ($spec->is_great) {
            $appends['is_great'] = $spec->is_great;
        }
        //开发商类型
        if ($spec->developer_type) {
            $appends['developer_type'] = $spec->developer_type;
        }
        //省份
        if ($spec->province_id) {
            $province_repository = new ProvinceRepository();
            $appends['province_id'] = $spec->province_id;

            /** @var ProvinceEntity $province_entity */
            $province_entity = $province_repository->fetch($spec->province_id);
            if (isset($province_entity)) {
                $appends['china_area_id'] = $province_entity->area_id;
                $appends['province_name'] = $province_entity->name;
            }
        }
        if ($spec->product_category_id) {
            $appends['product_category_id'] = $spec->product_category_id;

        }


        return $appends;
    }

    public function getDeveloperAppends(DeveloperSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }

}