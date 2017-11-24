<?php

namespace App\Wap\Service\Developer;

use App\Service\Product\ProductCategoryService;
use App\Src\Developer\Domain\Model\DeveloperEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectAirconditionerType;
use App\Src\Developer\Domain\Model\DeveloperProjectBrowseEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectCategoryType;
use App\Src\Developer\Domain\Model\DeveloperProjectContactEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectContactType;
use App\Src\Developer\Domain\Model\DeveloperProjectDecorateType;
use App\Src\Developer\Domain\Model\DeveloperProjectElevatorType;
use App\Src\Developer\Domain\Model\DeveloperProjectEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectFavoriteEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectSpecification;
use App\Src\Developer\Domain\Model\DeveloperProjectStageBuildType;
use App\Src\Developer\Domain\Model\DeveloperProjectStageDecorateType;
use App\Src\Developer\Domain\Model\DeveloperProjectStageDesignType;
use App\Src\Developer\Domain\Model\DeveloperProjectStageEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectStageType;
use App\Src\Developer\Domain\Model\DeveloperProjectSteelType;
use App\Src\Developer\Domain\Model\DeveloperProjectType;
use App\Src\Developer\Domain\Model\DeveloperType;
use App\Src\Developer\Infra\Repository\DeveloperProjectBrowseRepository;
use App\Src\Developer\Infra\Repository\DeveloperProjectCategoryRepository;
use App\Src\Developer\Infra\Repository\DeveloperProjectContactRepository;
use App\Src\Developer\Infra\Repository\DeveloperProjectContactVisitLogRepository;
use App\Src\Developer\Infra\Repository\DeveloperProjectFavoriteRepository;
use App\Src\Developer\Infra\Repository\DeveloperProjectRepository;
use App\Src\Developer\Infra\Repository\DeveloperProjectStageRepository;
use App\Src\Developer\Infra\Repository\DeveloperProjectStageTimeRepository;
use App\Src\Developer\Infra\Repository\DeveloperRepository;
use App\Src\Product\Domain\Model\ProductCategoryStatus;
use App\Src\Product\Domain\Model\ProductCategoryType;
use App\Src\Surport\Domain\Model\CityEntity;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\CityRepository;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Auth;

class DeveloperProjectWapService
{
    /**
     * 项目列表页
     * @param DeveloperProjectSpecification $spec
     * @param int                           $per_page
     * @return array
     */
    public function getDeveloperProjectList(DeveloperProjectSpecification $spec, $per_page)
    {
        $data = [];
        $items = [];
        $resource_repository = new ResourceRepository();
        $province_repository = new ProvinceRepository();
        $city_repository = new CityRepository();
        $developer_repository = new DeveloperRepository();
        $developer_project_repository = new DeveloperProjectRepository();
        $developer_project_stage_repository = new DeveloperProjectStageRepository();
        $developer_project_browse_repository = new DeveloperProjectBrowseRepository();
        $paginate = $developer_project_repository->search($spec, $per_page);

        /**
         * @var int                    $key
         * @var DeveloperProjectEntity $developer_project_entity
         * @var LengthAwarePaginator   $paginate
         */
        foreach ($paginate as $key => $developer_project_entity) {
            $item['id'] = $developer_project_entity->id;

            /** @var DeveloperProjectStageEntity $developer_project_stage_entity */
            $developer_project_stage_entity = $developer_project_stage_repository->fetch($developer_project_entity->project_stage_id);
            /** @var DeveloperEntity $developer_entity */
            $developer_entity = $developer_repository->fetch($developer_project_entity->developer_id);

            if (isset($developer_entity)) {
                /** @var ResourceEntity $resource_entity */
                $resource_entity = $resource_repository->fetch($developer_entity->logo);
                $item['logo_url'] = $resource_entity ? $resource_entity->url : '';
                $item['rank'] = $developer_entity->rank;
            }

            if (!empty($province_id = $developer_project_entity->province_id)) {
                $province_entity = $province_repository->fetch($province_id);
                $item['province'] = $province_entity ? $province_entity->toArray() : '';
            }

            if (!empty($city_id = $developer_project_entity->city_id)) {
                $city_entity = $city_repository->fetch($city_id);
                $item['city'] = $city_entity ? $city_entity->toArray() : '';
            }

            $item['is_read'] = false;
            if (request()->user()) {
                $developer_project_browse_entity = $developer_project_browse_repository->getUserBrowse(request()->user()->id, $developer_project_entity->id);
                if (isset($developer_project_browse_entity)) {
                    $item['is_read'] = true;
                }
            }

            $item['cost'] = $developer_project_entity->cost;
            $item['name'] = $developer_project_entity->name;
            $item['cost'] = $developer_project_entity->cost;
            $item['time'] = $developer_project_entity->time->toDateString();
            $item['is_great'] = $developer_project_entity->is_great;
            $item['developer_type'] = $developer_project_entity->developer_type;
            $item['developer_name'] = $developer_entity ? $developer_entity->name : '';
            $item['developer_stage_name'] = $developer_project_stage_entity ? $developer_project_stage_entity->name : '';

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
     * 项目详情页
     * @param int $id
     * @return array
     */
    public function getDeveloperProjectInfo($id)
    {
        $data = [];
        $province = '';
        $city = '';
        $developer_project_contact_visit_log_repository = new DeveloperProjectContactVisitLogRepository();
        $developer_project_stage_time_repository = new DeveloperProjectStageTimeRepository();
        $developer_project_favorite_repository = new DeveloperProjectFavoriteRepository();
        $developer_project_category_repository = new DeveloperProjectCategoryRepository();
        $developer_project_repository = new DeveloperProjectRepository();

        /** @var DeveloperProjectEntity $developer_project_entity */
        $developer_project_entity = $developer_project_repository->fetch($id);
        if (isset($developer_project_entity)) {
            $data = $developer_project_entity->toArray();

            $data['time'] = $developer_project_entity->time->format('Y年m月d日');
            $developer_id = $data['developer_id'] ?? 0;
            $developer_project_category_entities = $developer_project_category_repository->getDeveloperMainCategoriesByDeveloperProjectId($id) ?? [];
            $developer_category_ids = [];
            foreach ($developer_project_category_entities as $developer_project_category_entity) {
                $developer_category_ids[] = $developer_project_category_entity->product_category_id;
            }

            $data['product_category_names'] = '暂无';
            if (!empty($developer_category_ids)) {
                $product_category_service = new ProductCategoryService();
                $product_category_names = $product_category_service->getProductCategoryByIds($developer_category_ids);
                $data['product_category_names'] = $product_category_names;
            }
            $check_stage_type = [DeveloperProjectStageType::INVITATION, DeveloperProjectStageType::CLOSING];
            $developer_project_stage_time_entities = $developer_project_stage_time_repository->getDeveloperProjectStageTimeByProjectIdAndType(
                $id, $check_stage_type)->toArray();
            $stage_time = [];
            if ($developer_project_stage_time_entities) {
                if ($start_stage_time = current($developer_project_stage_time_entities)) {
                    $stage_time['start_time'] = $start_stage_time->time->format('Y.m.d');
                }
                if ($close_stage_time = next($developer_project_stage_time_entities)) {
                    $stage_time['close_time'] = $close_stage_time->time->format('Y.m.d');
                }
            }

            if ($developer_id) {
                $developer_repository = new DeveloperRepository();
                /** @var DeveloperEntity $developer_entity */
                $developer_entity = $developer_repository->fetch($developer_id);
                if (isset($developer_entity) && !empty($logo_id = $developer_entity->logo)) {
                    $developer_info = $developer_entity->toArray();
                    $resource_repository = new ResourceRepository();
                    $resource_entities = $resource_repository->getResourceUrlByIds($logo_id);
                    $resource_entity = current($resource_entities);
                    $developer_info['developer_logo_url'] = $resource_entity ? $resource_entity->url : '';
                    $data['developer_info'] = $developer_info;
                }
            }

            if ($data['province_id']) {
                $province_repository = new ProvinceRepository();
                /** @var ProvinceEntity $province_entity */
                $province_entity = $province_repository->fetch($data['province_id']);
                $province = $province_entity ? $province_entity->name : '';
            }
            if ($data['city_id']) {
                $city_repository = new CityRepository();
                /** @var CityEntity $city_entity */
                $city_entity = $city_repository->fetch($data['city_id']);
                $city = $city_entity ? $city_entity->name : '';
            }

            /** @var DeveloperProjectFavoriteEntity $developer_project_favorite_entity */
            $developer_project_favorite_entity = $developer_project_favorite_repository->getFavoriteByUserIdAndProjectId(Auth::id(), $id);

            $project_airconditioner_type_array = DeveloperProjectAirconditionerType::acceptableEnums(); //空调
            $developer_project_category_type_array = DeveloperProjectCategoryType::acceptableEnums(); //项目类别
            $developer_project_elevator_type_array = DeveloperProjectElevatorType::acceptableEnums(); //电梯
            $project_stage_decorate_type_array = DeveloperProjectStageDecorateType::acceptableEnums(); //装修阶段
            $project_stage_design_type_array = DeveloperProjectStageDesignType::acceptableEnums(); // 设计阶段
            $project_stage_build_type_array = DeveloperProjectStageBuildType::acceptableEnums(); //施工阶段
            $project_decorate_type_array = DeveloperProjectDecorateType::acceptableEnums(); //精装修
            $project_steel_type_array = DeveloperProjectSteelType::acceptableEnums(); //钢结构
            $developer_project_type_array = DeveloperProjectType::acceptableEnums(); //项目类型
            $developer_type_array = DeveloperType::acceptableEnums(); //开发商类型

            $data['province'] = $province;
            $data['city'] = $city;
            $data['stage_time'] = $stage_time;
            $data['type_name'] = $developer_project_type_array[$data['type']] ?? '未知';
            $data['has_favorite'] = $developer_project_favorite_entity ? true : false;
            $data['developer_type_name'] = $developer_type_array[$data['developer_type']] ?? '未知';
            $data['project_airconditioner_name'] = $project_airconditioner_type_array[$data['has_airconditioner']] ?? '未知';
            //室内精装修阶段
            $data['project_stage_decorate_name'] = $project_stage_decorate_type_array[$data['stage_decorate']] ?? '未知';
            $data['project_elevator_name'] = $developer_project_elevator_type_array[$data['has_elevator']] ?? '未知';
            //主体设计阶段
            $data['project_stage_design_name'] = $project_stage_design_type_array[$data['stage_design']] ?? '未知';
            //主体施工阶段
            $data['project_stage_build_name'] = $project_stage_build_type_array[$data['stage_build']] ?? '未知';
            $data['project_steel_name'] = $project_steel_type_array[$data['has_steel']] ?? '未知';
            $data['has_decorate_name'] = $project_decorate_type_array[$data['has_decorate']] ?? '未知';
            $data['developer_project_category_name'] = $developer_project_category_type_array[$data['project_category']] ?? '未知';
            $data['project_start'] = Carbon::parse($data['time_start'])->format('Y年m月d日');
            $data['project_end'] = Carbon::parse($data['time_end'])->format('Y年m月d日');

            $project_contact_visit_count = $developer_project_contact_visit_log_repository->getProjectContactVisitLogByProjectId($id)->count();
            $project_hot = $this->getProjectHot($project_contact_visit_count);
            $data['project_hot'] = $project_hot;

            //是否收藏
            $data['has_favorite'] = false;
            if (request()->user()) {
                $user_id = request()->user()->id;
                $developer_project_favorite_repository = new DeveloperProjectFavoriteRepository();
                $developer_project_favorite_entities = $developer_project_favorite_repository->getFavoriteByUserIdAndProjectId(
                    $user_id, $id);
                if (!$developer_project_favorite_entities->isEmpty()) {
                    $data['has_favorite'] = true;
                }
            }
        }

        return $data;
    }


    public function getSearchProductCategories()
    {
        $product_category_service = new ProductCategoryService();
        $product_categories = $product_category_service->getProductCategoryByParentId(
            ProductCategoryType::FURNISHINGS,
            ProductCategoryStatus::STATUS_ONLINE);

        return $product_categories;
    }

    /**
     * 项目热度等级 建议文案
     * @param $project_contact_visit_count
     * @return array
     */
    public function getProjectHot($project_contact_visit_count)
    {
        $data = [];
        $data['project_contact_visit_count'] = $project_contact_visit_count;
        switch ($project_contact_visit_count) {
            case ($project_contact_visit_count === 0):
                $data['hot'] = 1;
                $data['copywriter'] = '对项目感兴趣的供应商较少，建议您尽快联系业主。';
                break;
            case ($project_contact_visit_count > 0 && $project_contact_visit_count <= 5):
                $data['hot'] = 1;
                $data['copywriter'] = '对项目感兴趣的供应商较少，建议您尽快联系业主。';
                break;
            case ($project_contact_visit_count > 5 && $project_contact_visit_count <= 10):
                $data['hot'] = 2;
                $data['copywriter'] = '对项目感兴趣的供应商较少，建议您尽快联系业主。';
                break;
            case ($project_contact_visit_count > 10 && $project_contact_visit_count <= 15):
                $data['hot'] = 3;
                $data['copywriter'] = '该项目的竞争较为激烈，建议您查看其他项目。';
                break;
            case ($project_contact_visit_count > 15 && $project_contact_visit_count <= 20):
                $data['hot'] = 4;
                $data['copywriter'] = '该项目的竞争较为激烈，建议您查看其他项目。';
                break;
            default:
                $data['hot'] = 5;
                $data['copywriter'] = '该项目的竞争较为激烈，建议您查看其他项目。';
        }

        return $data;
    }

    public function setProjectBrowseRecord($user_id, $p_id)
    {
        $developer_project_browse_repository = new DeveloperProjectBrowseRepository();
        $developer_project_browse_entity = $developer_project_browse_repository->getUserBrowse($user_id, $p_id);
        if (!isset($developer_project_browse_entity)) {
            $developer_project_browse_entity = new DeveloperProjectBrowseEntity();
            $developer_project_browse_entity->user_id = $user_id;
            $developer_project_browse_entity->p_id = $p_id;
            $developer_project_browse_entity->type = 1;
            $developer_project_browse_repository->save($developer_project_browse_entity);
        }
    }

}