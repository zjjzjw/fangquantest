<?php

namespace App\Wap\Http\Controllers\Api\Exhibition;


use App\Service\Developer\DeveloperProjectService;
use App\Service\Developer\DeveloperService;
use App\Src\Developer\Domain\Model\DeveloperSpecification;
use App\Src\Developer\Domain\Model\DeveloperProjectBiddingType;
use App\Web\Service\Developer\DeveloperProjectWebService;
use App\Wap\Src\Forms\Developer\DeveloperProject\DeveloperProjectSearchForm;
use App\Wap\Src\Forms\Developer\DeveloperSearchForm;
use App\Src\Developer\Domain\Model\DeveloperProjectSpecification;
use App\Src\Developer\Domain\Model\DeveloperProjectStatus;
use App\Service\Project\ProjectCategoryService;
use App\Wap\Http\Controllers\BaseController;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use App\Src\Developer\Domain\Model\DeveloperProjectAdType;
use Illuminate\Http\Request;


class DeveloperProjectController extends BaseController
{


    public function developerProjectListMore(Request $request, DeveloperProjectSearchForm $form)
    {
        $data = [];
        $developer_project_service = new DeveloperProjectService();
        $request->merge(['status' => DeveloperProjectStatus::YES]);
        $request->merge(['is_ad' => DeveloperProjectAdType::NO]);
        $form->validate($request->all());
        $per_page = $request->get('per_page', 6);
        //项目列表
        $data = $developer_project_service->getDeveloperProjectList($form->developer_project_specification, $per_page);
        $appends = $this->getDeveloperProjectListAppends($form->developer_project_specification);
        $appends['per_page'] = $per_page;
        $appends['page'] = $data['page']['current_page'] ?? 1;
        $data['appends'] = $appends;

        return response()->json($data, 200);
    }

    public function getDeveloperProjectListAppends(DeveloperProjectSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
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
        if ($spec->developer_id) {
            $appends['developer_id'] = $spec->developer_id;
        }
        return $appends;
    }


}


