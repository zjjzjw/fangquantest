<?php namespace App\Admin\Http\Controllers\Developer;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Developer\DeveloperProject\DeveloperProjectSearchForm;
use App\Service\Developer\DeveloperProjectService;
use App\Service\Developer\DeveloperProjectStageService;
use App\Service\Project\ProjectCategoryService;
use App\Src\Developer\Domain\Model\DeveloperProjectAdType;
use App\Src\Developer\Domain\Model\DeveloperProjectAirconditionerType;
use App\Src\Developer\Domain\Model\DeveloperProjectBiddingType;
use App\Src\Developer\Domain\Model\DeveloperProjectDecorateType;
use App\Src\Developer\Domain\Model\DeveloperProjectElevatorType;
use App\Src\Developer\Domain\Model\DeveloperProjectHasProjectCategoryEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectSourceType;
use App\Src\Developer\Domain\Model\DeveloperProjectSpecification;
use App\Src\Developer\Domain\Model\DeveloperProjectCategoryType;
use App\Src\Developer\Domain\Model\DeveloperProjectGreatType;
use App\Src\Developer\Domain\Model\DeveloperProjectStageBuildType;
use App\Src\Developer\Domain\Model\DeveloperProjectStageDecorateType;
use App\Src\Developer\Domain\Model\DeveloperProjectStageDesignType;
use App\Src\Developer\Domain\Model\DeveloperProjectStatus;
use App\Src\Developer\Domain\Model\DeveloperProjectSteelType;
use App\Src\Developer\Domain\Model\DeveloperProjectType;
use App\Service\Surport\ProvinceService;
use App\Service\Product\ProductCategoryService;
use App\Src\Developer\Infra\Repository\DeveloperProjectCategoryRepository;
use App\Src\Developer\Infra\Repository\DeveloperProjectHasProjectCategoryRepository;
use App\Src\Product\Domain\Model\ProductCategoryStatus;
use App\Src\Project\Domain\Model\ProjectCategoryStatus;
use Illuminate\Http\Request;

/**
 * 开发商项目
 * Class DeveloperProjectController
 * @package App\Admin\Http\Controllers\Developer
 */
class DeveloperProjectController extends BaseController
{
    public function index(Request $request, DeveloperProjectSearchForm $form, $developer_id)
    {
        $data = [];
        $developer_project_service = new DeveloperProjectService();
        $request->merge(['developer_id' => $developer_id]);
        $form->validate($request->all());
        $data = $developer_project_service->getDeveloperProjectList($form->developer_project_specification, 20);

        $appends = $this->getAppends($form->developer_project_specification);
        $data['appends'] = $appends;
        $data['developer_id'] = $developer_id;
        $data['developer_project_status'] = DeveloperProjectStatus::acceptableEnums();
        $view = $this->view('pages.developer.developer-project.index', $data);
        return $view;
    }

    public function edit(Request $request, $developer_id, $id)
    {
        $data = [];
        if (!empty($id) || !empty($developer_id)) {
            $developer_project_service = new DeveloperProjectService();
            $data = $developer_project_service->getDeveloperProjectInfo($id);
        }
        //项目阶段
        $developer_project_stageService = new DeveloperProjectStageService();
        $developer_project_stage_list = $developer_project_stageService->getDeveloperProjectStageList();
        $data['developer_project_stages'] = $developer_project_stage_list;
        //项目类型
        $data['developer_project_type'] = DeveloperProjectType::acceptableEnums();
        //项目类别
        $data['developer_project_category_type'] = DeveloperProjectCategoryType::acceptableEnums();
        //上架状态
        $data['developer_project_status'] = DeveloperProjectStatus::acceptableEnums();
        //是否优选
        $data['developer_project_great_type'] = DeveloperProjectGreatType::acceptableEnums();
        //设计阶段
        $data['developer_project_stage_design_type'] = DeveloperProjectStageDesignType::acceptableEnums();
        //施工阶段
        $data['developer_project_stage_build_type'] = DeveloperProjectStageBuildType::acceptableEnums();
        //装修阶段
        $data['developer_project_stage_decorate_type'] = DeveloperProjectStageDecorateType::acceptableEnums();
        //是否精装修
        $data['developer_project_decorate_type'] = DeveloperProjectDecorateType::acceptableEnums();
        //是否有空调
        $data['developer_project_airconditioner_type'] = DeveloperProjectAirconditionerType::acceptableEnums();
        //有无钢结构
        $data['developer_project_steel_type'] = DeveloperProjectSteelType::acceptableEnums();
        //有无电梯
        $data['developer_project_elevator_type'] = DeveloperProjectElevatorType::acceptableEnums();
        //数据来源
        $data['developer_project_source_type'] = DeveloperProjectSourceType::acceptableEnums();
        //是否广告
        $data['developer_project_ad_type'] = DeveloperProjectAdType::acceptableEnums();

        //采购类型
        $data['developer_project_bidding_type'] = DeveloperProjectBiddingType::acceptableEnums();

        $province_service = new ProvinceService();
        $areas = $province_service->getProvinceForSearch();
        $data['areas'] = $areas;
        $data['id'] = $id;

        //获取产品主营分类
        $product_category_service = new ProductCategoryService();
        $main_category = $product_category_service->getProviderMainCategoryList(ProductCategoryStatus::STATUS_ONLINE);
        $data['main_category'] = $main_category;

        $province_service = new ProvinceService();
        $areas = $province_service->getProvinceForSearch();

        //得到主营产品
        //得到二级分类
        $developer_main_category_repository = new DeveloperProjectCategoryRepository();
        $developer_main_category_models = $developer_main_category_repository->getDeveloperMainCategoriesByDeveloperProjectId($id);
        $developer_category_ids = [];
        foreach ($developer_main_category_models as $developer_main_category_model) {
            $developer_category_ids[] = $developer_main_category_model->product_category_id;
        }
        $data['product_category_ids'] = $developer_category_ids;
        $data['areas'] = $areas;
        //得到主营产品的名称
        if (!empty($data['product_category_ids'])) {
            $product_category_service = new ProductCategoryService();
            $product_category_names = $product_category_service->getProductCategoryByIds($data['product_category_ids']);
            $data['product_category_names'] = $product_category_names;
        }

        //获取项目分类
        $project_category_service = new ProjectCategoryService();
        $project_main_category = $project_category_service->getProjectCategoryMainList(ProjectCategoryStatus::STATUS_ONLINE);
        $data['project_main_category'] = $project_main_category;

        //得到项目类别名称
        $developer_project_has_project_category_repository = new DeveloperProjectHasProjectCategoryRepository();
        $developer_project_has_project_category_entities =
            $developer_project_has_project_category_repository->getDeveloperProjectCategoriesByDeveloperProjectId($id);
        $develop_project_has_project_category_ids = [];
        /** @var DeveloperProjectHasProjectCategoryEntity $developer_project_has_project_category_entity */
        foreach ($developer_project_has_project_category_entities as $developer_project_has_project_category_entity) {
            $develop_project_has_project_category_ids[] = $developer_project_has_project_category_entity->project_category_id;
        }
        $data['develop_project_has_project_category_ids'] = $develop_project_has_project_category_ids;
        if (!empty($data['develop_project_has_project_category_ids'])) {
            $project_category_service = new ProjectCategoryService();
            $developer_project_has_project_category_names =
                $project_category_service->getProjectCategoryNameByIds($data['develop_project_has_project_category_ids']);
            $data['developer_project_has_project_category_names'] = $developer_project_has_project_category_names;
        }

        $data['developer_id'] = $developer_id;

        $view = $this->view('pages.developer.developer-project.edit', $data);
        return $view;
    }

    public function getAppends(DeveloperProjectSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
            $appends['developer_id'] = $spec->developer_id;
        }
        if ($spec->status) {
            $appends['status'] = $spec->status;
        }
        return $appends;
    }
}
