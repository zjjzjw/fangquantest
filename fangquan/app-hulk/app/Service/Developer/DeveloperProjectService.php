<?php

namespace App\Hulk\Service\Developer;


use App\Service\Project\ProjectCategoryService;
use App\Src\Developer\Domain\Model\DeveloperEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectBiddingType;
use App\Src\Developer\Domain\Model\DeveloperProjectCategoryType;
use App\Src\Developer\Domain\Model\DeveloperProjectEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectGreatType;
use App\Src\Developer\Domain\Model\DeveloperProjectHasProjectCategoryEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectSpecification;
use App\Src\Developer\Domain\Model\DeveloperProjectStatus;
use App\Src\Developer\Domain\Model\DeveloperProjectType;
use App\Src\Developer\Infra\Repository\DeveloperProjectHasProjectCategoryRepository;
use App\Src\Developer\Infra\Repository\DeveloperProjectRepository;
use App\Src\Developer\Infra\Repository\DeveloperProjectStageRepository;
use App\Src\Developer\Infra\Repository\DeveloperRepository;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

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
        $developer_project_great_type = DeveloperProjectGreatType::acceptableEnums();
        $developer_project_stage_repository = new DeveloperProjectStageRepository();
        $province_repository = new ProvinceRepository();
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
            $item['name'] = $developer_project_entity->name;
            $item['type_name'] = $developer_project_category_types[$developer_project_entity->type];
            $item['floor_space'] = $developer_project_entity->floor_space;
            /** @var ProvinceEntity $province_entity */
            $province_entity = $province_repository->fetch($developer_project_entity->province_id);
            if (isset($province_entity)) {
                $item['province_name'] = $province_entity->name;
            }
            $item['time_start'] = Carbon::parse($developer_project_entity->time)->format('Y-m-d');
            /** @var DeveloperEntity $developer_entity */
            $developer_entity = $developer_repository->fetch($developer_project_entity->developer_id);
            if (isset($developer_entity)) {
                /** @var ResourceEntity $resource_entity */
                $resource_entity = $resource_repository->fetch($developer_entity->logo);
                $item['logo_url'] = $resource_entity ? $resource_entity->url : '';
                $item['developer_name'] = $developer_entity->name;
            }
            $category_name = [];
            foreach (($developer_project_entity->project_categories ?? []) as $value) {
                $category_name[] = $developer_project_category_types[$value];
            }
            $item['category_names'] = implode(',', $category_name);
            $items[] = $item;
        }

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
    public function getDeveloperProjectInfo($id)
    {
        $data = [];
        $developer_repository = new DeveloperRepository();
        $developer_project_repository = new DeveloperProjectRepository();
        $resource_repository = new ResourceRepository();
        $developer_project_category_types = DeveloperProjectCategoryType::acceptableEnums();
        $developer_project_bidding_type = DeveloperProjectBiddingType::acceptableEnums();
        /** @var DeveloperProjectEntity $developer_project_entity */
        $developer_project_entity = $developer_project_repository->fetch($id);
        if (isset($developer_project_entity)) {
            $data = $developer_project_entity->toArray();
            /** @var DeveloperEntity $developer_entity */
            $developer_entity = $developer_repository->fetch($developer_project_entity->developer_id);
            if (isset($developer_entity)) {
                /** @var ResourceEntity $resource_entity */
                $resource_entity = $resource_repository->fetch($developer_entity->logo);
                $data['logo_url'] = $resource_entity ? $resource_entity->url : '';
                $data['developer_name'] = $developer_entity->name;
            }
            $category_name = [];
            foreach (($developer_project_entity->project_categories ?? []) as $value) {
                $category_name[] = $developer_project_category_types[$value];
            }
            $data['category_names'] = implode(',', $category_name);
            $data['time'] = Carbon::parse($developer_project_entity->time)->format('Y-m-d');
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
                $data['developer_project_category_names'] = $developer_project_has_project_category_names;
            }

            $data['bidding_name'] = $developer_project_bidding_type[$developer_project_entity->bidding_type];
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

}

