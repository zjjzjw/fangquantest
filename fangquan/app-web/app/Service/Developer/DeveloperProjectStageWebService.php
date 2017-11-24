<?php

namespace App\Web\Service\Developer;


use App\Src\Developer\Domain\Model\DeveloperProjectStageEntity;
use App\Src\Developer\Infra\Repository\DeveloperProjectStageRepository;

class DeveloperProjectStageWebService
{
    public function getDeveloperProjectStageList()
    {
        $data = [];
        $developer_project_stage_repository = new DeveloperProjectStageRepository();
        $developer_project_stage_entities = $developer_project_stage_repository->all();
        $items = [];
        /** @var DeveloperProjectStageEntity $developer_project_stage_entity */
        foreach ($developer_project_stage_entities as $key => $developer_project_stage_entity) {
            $item = $developer_project_stage_entity->toArray();
            $items[] = $item;
        }

        return $items;
    }
}