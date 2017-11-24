<?php

namespace App\Mobi\Service\Developer;


use App\Src\Developer\Domain\Model\DeveloperProjectStageEntity;
use App\Src\Developer\Infra\Repository\DeveloperProjectStageRepository;
use App\Src\Developer\Infra\Repository\DeveloperProjectStageTimeRepository;

class DeveloperProjectStageMobiService
{

    /**
     * @param null $project_id
     * @param      $developer_stage_id
     * @return array
     */
    public function getDeveloperProjectStageList($project_id = null, $developer_stage_id = null)
    {
        $items = [];
        $developer_project_stage_repository = new DeveloperProjectStageRepository();
        $developer_project_stage_entities = $developer_project_stage_repository->all();
        /**
         * @var int                         $key
         * @var DeveloperProjectStageEntity $developer_project_stage_entity
         */
        if ($developer_stage_id == 4 || $developer_stage_id == 5) {
            $developer_project_stage_time_repository = new DeveloperProjectStageTimeRepository();
            foreach ($developer_project_stage_entities as $key => $developer_project_stage_entity) {
                $stage_id = $developer_project_stage_entity->id;
                if ($stage_id == 4 || $stage_id == 5) {
                    $developer_project_stage_time_entity = $developer_project_stage_time_repository->getDeveloperProjectStageTimeByProjectIdAndType($project_id, $stage_id);
                    if (isset($developer_project_stage_time_entity)) {
                        $developer_project_stage_arr = current($developer_project_stage_time_entity->toArray());
                        if ($developer_project_stage_arr) {
                            $item['time'] = $this->dateFormat($developer_project_stage_arr->time);
                        }
                    }
                }
                $item['project_stage_id'] = $stage_id;
                $item['name'] = $developer_project_stage_entity->name;
                $items[] = $item;
                unset($item['time']);
            }
        } else {
            foreach ($developer_project_stage_entities as $key => $developer_project_stage_entity) {
                $stage_id = $developer_project_stage_entity->id;
                $item['project_stage_id'] = $stage_id;
                $item['name'] = $developer_project_stage_entity->name;
                $items[] = $item;
            }
        }
        return $items;
    }

    public function dateFormat($date = null)
    {
        if (empty($date)) return '';
        $date_arr = explode(' ', $date);
        return $date_arr[0];
    }
}

