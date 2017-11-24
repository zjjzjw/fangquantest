<?php

namespace App\Service\Developer;


use App\Src\Developer\Domain\Model\DeveloperEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectCategoryType;
use App\Src\Developer\Domain\Model\DeveloperProjectGreatType;
use App\Src\Developer\Domain\Model\DeveloperProjectBiddingType;
use App\Src\Developer\Domain\Model\DeveloperProjectStageEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectStatus;
use App\Src\Developer\Domain\Model\DeveloperProjectType;
use App\Src\Developer\Infra\Repository\DeveloperProjectRepository;
use App\Src\Developer\Domain\Model\DeveloperProjectEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectSpecification;
use App\Src\Developer\Infra\Repository\DeveloperProjectStageRepository;
use App\Src\Developer\Infra\Repository\DeveloperRepository;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Domain\Model\CityEntity;
use App\Src\Surport\Infra\Repository\CityRepository;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class DeveloperProjectService
{
    /**
     * @param DeveloperProjectSpecification $spec
     * @param int                           $per_page
     * @return array
     */
    public function getDeveloperProjectList(DeveloperProjectSpecification $spec, $per_page)
    {
        $data = [];
        $developer_project_repository = new DeveloperProjectRepository();
        $paginate = $developer_project_repository->search($spec, $per_page);
        $developer_project_type = DeveloperProjectType::acceptableEnums();
        $developer_project_category_types = DeveloperProjectCategoryType::acceptableEnums();
        $developer_project_status = DeveloperProjectStatus::acceptableEnums();
        $developer_project_bidding_type = DeveloperProjectBiddingType::acceptableEnums();
        $developer_project_great_type = DeveloperProjectGreatType::acceptableEnums();
        $developer_project_stage_repository = new DeveloperProjectStageRepository();
        $developer_repository = new DeveloperRepository();
        $resource_repository = new ResourceRepository();
        $city_repository = new CityRepository();
        $items = [];
        /**
         * @var int                    $key
         * @var DeveloperProjectEntity $developer_project_entity
         * @var LengthAwarePaginator   $paginate
         */
        foreach ($paginate as $key => $developer_project_entity) {
            $item = $developer_project_entity->toArray();
            $item['time'] = Carbon::parse($item['time'])->format('Y-m');
            $developer_id = $item['developer_id'];
            $develop_entity = $developer_repository->fetch($developer_id);

            $resource_entity = $resource_repository->fetch($develop_entity->logo);
            //给一个默认图片
            $item['logo_url'] = '/www/images/provider/default_logo.png';
            if (isset($resource_entity)) {
                $item['logo_url'] = $resource_entity->url;
            }

            $item['developer_name'] = $develop_entity->name ?? '';
            $item['type_name'] = $developer_project_type[$item['type']] ?? '';
            //$item['project_category_name'] = $developer_project_category_types[$item['project_category']] ?? '';
            $item['project_category_name'] = $this->getProjectCategoryTypeName($item['project_categories']);

            /** @var CityEntity $city_entity */
            $city_entity = $city_repository->fetch($item['city_id']);
            if (isset($city_entity)) {
                $item['city_name'] = $city_entity->name;
            }
            $item['status_name'] = $developer_project_status[$item['status']] ?? '';
            $item['bidding_type_name'] = $developer_project_bidding_type[$item['bidding_type']] ?? '';
            $item['great_name'] = $developer_project_great_type[$item['is_great']] ?? '';
            /** @var DeveloperProjectStageEntity $developer_project_stage_entity */
            $developer_project_stage_entity = $developer_project_stage_repository->fetch($item['project_stage_id']);
            if (isset($developer_project_stage_entity)) {
                $item['project_stage_name'] = $developer_project_stage_entity->name;
            }
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
     * 得到项目类型名称
     * @param array $type_ids
     * @return string
     */
    public function getProjectCategoryTypeName($type_ids)
    {
        if (empty($type_ids)) {
            return '';
        }
        $type_names = [];
        $project_category_types = DeveloperProjectCategoryType::acceptableEnums();
        foreach ($type_ids as $type_id) {
            $type_names[] = $project_category_types[$type_id] ?? '';
        }
        $type_names = array_filter($type_names);
        return implode(',', $type_names);
    }


    /**
     * @param $id
     * @return array
     */
    public function getDeveloperProjectInfo($id)
    {
        $data = [];
        $developer_project_repository = new DeveloperProjectRepository();
        $developer_project_entity = $developer_project_repository->fetch($id);
        if (isset($developer_project_entity)) {
            $data = $developer_project_entity->toArray();
        }
        return $data;
    }


    /**
     *
     * @return array
     */
    public function getAdDeveloperProjectList($status, $limit)
    {
        $items = [];
        $developer_project_repository = new DeveloperProjectRepository();
        $developer_repository = new DeveloperRepository();
        $resource_repository = new ResourceRepository();
        $developer_project_entities = $developer_project_repository->getAdDeveloperProjectList($status, $limit);
        /** @var  $developer_project_entity */
        foreach ($developer_project_entities as $developer_project_entity) {
            $item = $developer_project_entity->toArray();
            /** @var DeveloperEntity $developer_entity */
            $developer_entity = $developer_repository->fetch($developer_project_entity->developer_id);
            if (isset($developer_entity)) {
                /** @var ResourceEntity $resource_entity */
                $resource_entity = $resource_repository->fetch($developer_entity->logo);
                $item['logo_url'] = $resource_entity ? $resource_entity->url : '';
            }
            $items[] = $item;
        }
        return $items;
    }

    /**
     * @param int       $limit
     * @param int|array $status
     * @return array
     */
    public function getTopDeveloperProjects($limit, $status)
    {
        $items = [];
        $developer_project_repository = new DeveloperProjectRepository();
        $developer_repository = new DeveloperRepository();
        $developer_project_entities = $developer_project_repository->getTopDeveloperProjects(
            $limit, DeveloperProjectStatus::YES);
        /** @var DeveloperProjectEntity $developer_project_entity */
        foreach ($developer_project_entities as $developer_project_entity) {
            $item = $developer_project_entity->toArray();

            /** @var DeveloperEntity $developer_entity */
            $developer_entity = $developer_repository->fetch($developer_project_entity->developer_id);
            $item['developer_name'] = $developer_entity->name;
            $item['rank'] = $developer_entity->rank;

            $items[] = $item;
        }

        return $items;
    }

    public function updateStatus($developer_id, $status)
    {
        $developer_project_repository = new DeveloperProjectRepository();
        $developer_project_entities = $developer_project_repository->getProjectListByDeveloperId($developer_id);
        /** @var DeveloperProjectEntity $developer_project_entity */
        foreach ($developer_project_entities as $developer_project_entity) {
            $developer_project_entity->status = $status;
            $developer_project_repository->save($developer_project_entity);
        }
    }


}

