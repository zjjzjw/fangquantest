<?php

namespace App\Service\Developer;


use App\Src\Developer\Domain\Model\DeveloperProjectStageEntity;
use App\Src\Developer\Infra\Repository\DeveloperProjectStageRepository;
use App\Src\Developer\Infra\Repository\DeveloperProjectStageTimeRepository;
use App\Src\Developer\Domain\Model\DeveloperProjectStageTimeEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectStageTimeSpecification;
use Illuminate\Pagination\LengthAwarePaginator;

class DeveloperProjectStageTimeService
{
    /**
     * @param DeveloperProjectStageTimeSpecification $spec
     * @param int                                    $per_page
     * @return array
     */
    public function getDeveloperProjectStageTimeContactList(DeveloperProjectStageTimeSpecification $spec, $per_page)
    {
        $data = [];
        $developer_project_stage_time_repository = new DeveloperProjectStageTimeRepository();
        $developer_project_stage_repository = new DeveloperProjectStageRepository();
        $paginate = $developer_project_stage_time_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var int                             $key
         * @var DeveloperProjectStageTimeEntity $developer_project_stage_time_entity
         * @var LengthAwarePaginator            $paginate
         */
        foreach ($paginate as $key => $developer_project_stage_time_entity) {
            $item = $developer_project_stage_time_entity->toArray();

            /** @var DeveloperProjectStageEntity $developer_project_stage_entity */
            $developer_project_stage_entity = $developer_project_stage_repository->fetch($item['stage_type']);
            if (isset($developer_project_stage_entity)) {
                $item['stage_name'] = $developer_project_stage_entity->name;
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
     * @param $id
     * @return array
     */
    public function getDeveloperProjectStageTimeInfo($id)
    {
        $data = [];
        $developer_project_stage_time_repository = new DeveloperProjectStageTimeRepository();
        $developer_project_stage_time_entity = $developer_project_stage_time_repository->fetch($id);
        if (isset($developer_project_stage_time_entity)) {
            $data = $developer_project_stage_time_entity->toArray();
        }
        return $data;
    }
}

