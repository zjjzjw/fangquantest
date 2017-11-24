<?php

namespace App\Mobi\Service\Developer;


use App\Service\FqUser\CheckTokenService;
use App\Src\Advertisement\Infra\Repository\AdvertisementRepository;
use App\Src\Developer\Domain\Model\DeveloperEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectAirconditionerType;
use App\Src\Developer\Domain\Model\DeveloperProjectCategoryType;
use App\Src\Developer\Domain\Model\DeveloperProjectDecorateType;
use App\Src\Developer\Domain\Model\DeveloperProjectElevatorType;
use App\Src\Developer\Domain\Model\DeveloperProjectStageBuildType;
use App\Src\Developer\Domain\Model\DeveloperProjectStageDecorateType;
use App\Src\Developer\Domain\Model\DeveloperProjectStageDesignType;
use App\Src\Developer\Domain\Model\DeveloperProjectStageEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectStageType;
use App\Src\Developer\Domain\Model\DeveloperProjectSteelType;
use App\Src\Developer\Domain\Model\DeveloperProjectType;
use App\Src\Developer\Infra\Repository\DeveloperProjectCategoryRepository;
use App\Src\Developer\Infra\Repository\DeveloperProjectFavoriteRepository;
use App\Src\Developer\Infra\Repository\DeveloperProjectRepository;
use App\Src\Developer\Infra\Repository\DeveloperRepository;
use App\Src\Developer\Domain\Model\DeveloperProjectEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectSpecification;
use App\Src\Developer\Infra\Repository\DeveloperProjectStageRepository;
use App\Src\Product\Domain\Model\ProductCategoryEntity;
use App\Src\Product\Infra\Repository\ProductCategoryRepository;
use App\Src\Surport\Domain\Model\CityEntity;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\CityRepository;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use App\Service\Product\ProductCategoryService;

class DeveloperProjectMobiService
{
    /**
     * @param DeveloperProjectSpecification $spec
     * @param int                           $per_page
     * @return array
     */
    public function getDeveloperProjectList(DeveloperProjectSpecification $spec, $per_page)
    {
        $result = [];
        $developer_project_repository = new DeveloperProjectRepository();
        //判断是否存在筛选和搜索
        $is_choose_or_search = $this->chooseOrSearch($spec);
        if (!$is_choose_or_search) {
            $spec->is_ad = false;
        }
        $paginate = $developer_project_repository->search($spec, $per_page);
        $developer_project_items = $this->formatDeveloperProjectList($paginate);
        if ($spec->page == 1 && $is_choose_or_search) {
            $ad = 1;
            //获取有广告的信息
            if ($ad == 1) {
                $developer_project_ad_items = $this->getIsAdProject();
            } else {
                $advertisement_repository = new AdvertisementRepository();
                $advertisement_entity = $advertisement_repository->getAdvertisementList(3);
                $developer_project_ad_items = $this->adPictureList($advertisement_entity);
            }
            if (isset($developer_project_ad_items[0])) {
                $developer_project_items = $this->addAdDeveloperProject($developer_project_items, 0, $developer_project_ad_items[0]);
            }
            if (isset($developer_project_ad_items[1])) {
                $developer_project_items = $this->addAdDeveloperProject($developer_project_items, 5, $developer_project_ad_items[1]);
            }
            if (isset($developer_project_ad_items[2])) {
                $developer_project_items = $this->addAdDeveloperProject($developer_project_items, 9, $developer_project_ad_items[2]);
            }
            $developer_project_items = array_slice($developer_project_items, 0, 10, true);
        }
        $result['list'] = $developer_project_items;
        $result['total'] = $paginate->total();
        return $result;
    }

    /**
     * 获取广告项目
     * @return array
     */
    public function getIsAdProject()
    {
        $developer_project_repository = new DeveloperProjectRepository();
        $developer_project_ad_entities = $developer_project_repository->getDeveloperProjectIsAd();
        $developer_project_ad_items = $this->formatDeveloperProjectList($developer_project_ad_entities, true);
        return $developer_project_ad_items;
    }

    /**
     * 判断是否存在筛选和搜索
     * @param $spec
     * @return bool
     */
    public function chooseOrSearch($spec)
    {
        if (!empty($spec->keyword)) {
            return false;
        } elseif (!empty($spec->project_stage_id)) {
            return false;
        } elseif (!empty($spec->province_id)) {
            return false;
        } elseif (!empty($spec->product_category_id)) {
            return false;
        }
        return true;
    }

    /**
     * @param $advertisement_entity
     * @return array
     */
    public function adPictureList($advertisement_entity)
    {
        $data = [];
        $resource_repository = new ResourceRepository();
        foreach ($advertisement_entity as $advertisement) {
            if (isset($advertisement->image_id)) {
                $resource_entities = $resource_repository->getResourceUrlByIds($advertisement->image_id);
            } else {
                $resource_entities = '';
            }
            $ad['image_url'] = $resource_entities ? current($resource_entities)->url : '';
            $ad['link'] = $advertisement->link;
            $ad['is_ad'] = true;
            $ad['is_picture_ad'] = true;
            $data[] = $ad;
        }
        return $data;
    }


    public function formatDeveloperProjectList($paginate, $is_ad = false)
    {
        $developer_project_stage_repository = new DeveloperProjectStageRepository();
        $city_repository = new CityRepository();
        $developer_repository = new DeveloperRepository();
        $resource_repository = new ResourceRepository();
        $items = [];
        /**
         * @var int                    $key
         * @var DeveloperProjectEntity $developer_project_entity
         * @var LengthAwarePaginator   $paginate
         */
        foreach ($paginate as $key => $developer_project_entity) {
            $item['id'] = $developer_project_entity->id;
            /** @var DeveloperEntity $developer_entity */
            $developer_entity = $developer_repository->fetch($developer_project_entity->developer_id);
            if (isset($developer_entity)) {
                //得到缩略图
                /** @var ResourceEntity $resource_entity */
                $resource_entity = $resource_repository->fetch($developer_entity->logo);
                if (isset($resource_entity)) {
                    $item['logo'] = $resource_entity->url;
                } else {
                    $item['logo'] = '';
                }
            }
            if ($is_ad) {
                $item['is_ad'] = true;
                $item['is_picture_ad'] = false;
            } else {
                $item['is_ad'] = false;
            }
            $item['developer_type'] = $developer_project_entity->developer_type;
            $item['name'] = $developer_project_entity->name;
            if (!empty($developer_project_entity->city_id)) {
                /** @var CityEntity $city_entity */
                $city_entity = $city_repository->fetch($developer_project_entity->city_id);
                $item['address'] = $city_entity->name;
            } else {
                $item['address'] = '';
            }
            $item['cost'] = $developer_project_entity->cost;
            if (isset($developer_project_entity->time)) {
                $time = $developer_project_entity->time->toDateTimeString();
                $item['time'] = current(explode(' ', $time));
            }
            /** @var DeveloperProjectStageEntity $developer_project_stage_entity */
            $developer_project_stage_entity = $developer_project_stage_repository->fetch($developer_project_entity->project_stage_id);
            if (isset($developer_project_stage_entity)) {
                $project_stage = DeveloperProjectStageType::acceptableAppColourEnums();
                $item['developer_stage_name'] = $developer_project_stage_entity->name;
                $item['project_stage_id'] = $developer_project_stage_entity->id;
                $item['project_stage_colour'] = $project_stage[$developer_project_stage_entity->id] ?? '';
            }
            if (isset($developer_entity)) {
                $item['developer_name'] = $developer_entity->name;
                $item['developer_rank'] = $developer_entity->rank;
            }
            $items[] = $item;
        }

        return $items;
    }

    /**
     * 新增广告
     * @param $array
     * @param $position
     * @param $value
     * @return array
     */
    public function addAdDeveloperProject($array, $position, $value)
    {
        $provider_entities_arr = [];
        for ($i = 0; $i <= count($array); $i++) {
            if ($i == $position) {
                $provider_entities_arr[$position] = $value;
            } elseif ($i < $position) {
                $provider_entities_arr[$i] = $array[$i];
            } else {
                $provider_entities_arr[$i] = $array[$i - 1];
            }
        }
        return $provider_entities_arr;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getDeveloperProjectInfo($id)
    {
        $data = [];
        $province_name = '';
        $city_name = '';
        $city_repository = new CityRepository();
        $province_repository = new ProvinceRepository();
        $developer_project_repository = new DeveloperProjectRepository();
        $developer_project_stage_repository = new DeveloperProjectStageRepository();
        $developer_repository = new DeveloperRepository();
        $resource_repository = new ResourceRepository();
        $developer_project_category_repository = new DeveloperProjectCategoryRepository();
        /** @var DeveloperProjectEntity $developer_project_entity */
        $developer_project_entity = $developer_project_repository->fetch($id);
        if (isset($developer_project_entity)) {
            $data['id'] = $developer_project_entity->id;
            $data['name'] = $developer_project_entity->name;
            $data['time'] = $developer_project_entity->time->toDateTimeString();
            /** @var DeveloperEntity $developer_entity */
            $developer_entity = $developer_repository->fetch($developer_project_entity->developer_id);
            if (isset($developer_entity)) {
                //得到缩略图
                /** @var ResourceEntity $resource_entity */
                $resource_entity = $resource_repository->fetch($developer_entity->logo);
                if (isset($resource_entity)) {
                    $data['logo'] = $resource_entity->url;
                } else {
                    $data['logo'] = '';
                }
                $data['developer_name'] = $developer_entity->name;
            } else {
                $data['developer_name'] = '';
            }
            if (!empty($developer_project_entity->province_id)) {
                /** @var ProvinceEntity $province_entity */
                $province_entity = $province_repository->fetch($developer_project_entity->province_id);
                $province_name = $province_entity->name;
            }
            if (!empty($developer_project_entity->city_id)) {
                /** @var CityEntity $city_entity */
                $city_entity = $city_repository->fetch($developer_project_entity->city_id);
                $city_name = $city_entity->name;
            }
            $data['address'] = $province_name . $city_name . $developer_project_entity->address;
            //项目类型
            $developer_project_type = DeveloperProjectType::acceptableEnums();
            $data['type'] = $developer_project_type[$developer_project_entity->type] ?? '';

            $developer_project_favorite_repository = new DeveloperProjectFavoriteRepository();
            /** @var DeveloperProjectStageEntity $developer_project_stage_entity */
            $developer_project_stage_entity = $developer_project_stage_repository->fetch($developer_project_entity->project_stage_id);
            if (isset($developer_project_stage_entity)) {
                $developer_project_stage_service = new DeveloperProjectStageMobiService();
                $developer_project_stage_list = $developer_project_stage_service->getDeveloperProjectStageList($id, $developer_project_entity->project_stage_id);
                $data['developer_stage'] = $developer_project_stage_list;
                $data['developer_stage_name'] = $developer_project_stage_entity->name;
                $data['project_stage_id'] = $developer_project_stage_entity->id;
            } else {
                $data['developer_stage_name'] = '';
            }
            //设计阶段
            $developer_project_stage_design_types = DeveloperProjectStageDesignType::acceptableEnums();
            $data['stage_design'] = $developer_project_stage_design_types[$developer_project_entity->stage_design] ?? '';
            //施工阶段
            $developer_project_stage_build_types = DeveloperProjectStageBuildType::acceptableEnums();
            $data['stage_build'] = $developer_project_stage_build_types[$developer_project_entity->stage_build] ?? '';
            //装修阶段
            $developer_project_stage_decorate_types = DeveloperProjectStageDecorateType::acceptableEnums();
            $data['stage_decorate'] = $developer_project_stage_decorate_types[$developer_project_entity->stage_decorate] ?? '';

            $data['floor_space'] = $developer_project_entity->floor_space;
            $data['floor_numbers'] = $developer_project_entity->floor_numbers;
            $data['cost'] = $developer_project_entity->cost;
            $data['investments'] = $developer_project_entity->investments;
            $data['heating_mode'] = $developer_project_entity->heating_mode;
            $data['wall_materials'] = $developer_project_entity->wall_materials;

            //设计阶段
            $developer_project_decorate_types = DeveloperProjectDecorateType::acceptableEnums();
            if (!empty($developer_project_entity->has_decorate)) {
                $data['has_decorate'] = $developer_project_decorate_types[$developer_project_entity->has_decorate];
            }
            $developer_project_airconditioner_types = DeveloperProjectAirconditionerType::acceptableEnums();
            $data['has_airconditioner'] = $developer_project_airconditioner_types[$developer_project_entity->has_airconditioner] ?? '';

            $developer_project_steel_types = DeveloperProjectSteelType::acceptableEnums();
            $data['has_steel'] = $developer_project_steel_types[$developer_project_entity->has_steel] ?? '';

            $developer_project_elevator_types = DeveloperProjectElevatorType::acceptableEnums();
            $data['has_elevator'] = $developer_project_elevator_types[$developer_project_entity->has_elevator] ?? '';

            //供应商项目的产品类别
            $developer_project_category = [];
            /** @var ProductCategoryEntity $product_category_entity */
            $product_category_repository = new ProductCategoryRepository();
            $developer_project_category_entities = $developer_project_category_repository->getDeveloperMainCategoriesByDeveloperProjectId($id);
            foreach ($developer_project_category_entities as $developer_project_category_entity) {
                $product_category_id = $developer_project_category_entity->product_category_id;
                if (isset($product_category_id)) {
                    $product_category_entity = $product_category_repository->fetch($product_category_id);
                    $developer_project_category[] = $product_category_entity->name;
                }
            }
            $data['developer_project_category'] = implode(',', $developer_project_category);
            $data['summary'] = $developer_project_entity->summary;

            $developer_project_category_type = DeveloperProjectCategoryType::acceptableEnums();
            $data['project_category'] = $developer_project_category_type[$developer_project_entity->project_category] ?? '';

            //项目时间
            $data['developer_time'] = current(explode(' ', $developer_project_entity->time_start)) . '-' . current(explode(' ', $developer_project_entity->time_end));
            $data['project_hot'] = [
                'provider_count' => 0,
                'hot_count'      => 0,
            ];
            $data['has_collected'] = false;
            if (CheckTokenService::isLogin()) {
                $user_id = CheckTokenService::getUserId();
                $developer_project_favorite_entity = $developer_project_favorite_repository->getFavoriteByUserIdAndProjectId(
                    $user_id, $developer_project_entity->id);
                if (!$developer_project_favorite_entity->isEmpty()) {
                    $data['has_collected'] = true;
                }
            }
        }

        return $data;
    }
}

