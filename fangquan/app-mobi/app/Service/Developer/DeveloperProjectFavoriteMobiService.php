<?php

namespace App\Mobi\Service\Developer;


use App\Mobi\Src\Forms\Developer\DeveloperProjectFavorite\DeveloperProjectFavoriteStoreForm;
use App\Service\FqUser\CheckTokenService;
use App\Src\Developer\Domain\Model\DeveloperEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectAdType;
use App\Src\Developer\Domain\Model\DeveloperProjectEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectFavoriteEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectFavoriteType;
use App\Src\Developer\Domain\Model\DeveloperProjectStageEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectStageType;
use App\Src\Developer\Infra\Repository\DeveloperProjectFavoriteRepository;
use App\Src\Developer\Infra\Repository\DeveloperProjectRepository;
use App\Src\Developer\Infra\Repository\DeveloperRepository;
use App\Src\Developer\Infra\Repository\DeveloperProjectStageRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;

class DeveloperProjectFavoriteMobiService
{
    /**
     * @param $user_id
     * @return array
     */
    public function getFavoriteProjectByUserId($user_id)
    {
        $developer_project_favorite_repository = new DeveloperProjectFavoriteRepository();
        $developer_project_repository = new DeveloperProjectRepository();
        $developer_repository = new DeveloperRepository();
        $developer_project_stage_repository = new DeveloperProjectStageRepository();
        $resource_repository = new ResourceRepository();
        $developer_project_favorite_entities = $developer_project_favorite_repository->getFavoriteRecordByUserId($user_id);
        $items = [];
        if ($developer_project_favorite_entities->isEmpty()) {
            return $items;
        }
        /**
         * @var int                            $key
         * @var DeveloperProjectFavoriteEntity $developer_project_favorite_entities
         */
        foreach ($developer_project_favorite_entities as $key => $developer_project_favorite_entity) {
            $item['id'] = $developer_project_favorite_entity->developer_project_id;
            /** @var DeveloperProjectEntity $developer_project_entity */
            $developer_project_entity = $developer_project_repository->fetch($item['id']);
            if (isset($developer_project_entity)) {
                $item['name'] = $developer_project_entity->name;
                $item['address'] = $developer_project_entity->address;
                $item['cost'] = $developer_project_entity->cost;
                /** @var DeveloperProjectStageEntity $developer_project_stage_entity */
                $developer_project_stage_entity = $developer_project_stage_repository->fetch($developer_project_entity->project_stage_id);
                if (isset($developer_project_stage_entity)) {
                    $project_stage = DeveloperProjectStageType::acceptableAppColourEnums();
                    $item['developer_stage_name'] = $developer_project_stage_entity->name;
                    $item['project_stage_colour'] = $project_stage[$developer_project_stage_entity->id] ?? '';
                }
                if ($developer_project_entity->is_ad == DeveloperProjectAdType::YES) {
                    $item['is_ad'] = true;
                    $item['is_picture_ad'] = false;
                } else {
                    $item['is_ad'] = false;
                }
                /** @var DeveloperEntity $developer_entity */
                $developer_entity = $developer_repository->fetch($developer_project_entity->developer_id);
                if (isset($developer_entity)) {
                    $item['developer_name'] = $developer_entity->name;
                    $item['developer_rank'] = $developer_entity->rank;
                    //得到缩略图
                    /** @var ResourceEntity $resource_entity */
                    $resource_entity = $resource_repository->fetch($developer_entity->logo);
                    if (isset($resource_entity)) {
                        $item['logo'] = $resource_entity->url;
                    }
                }
            }
            $items[] = $item;
        }
        return $items;
    }

    /**
     * @param DeveloperProjectFavoriteStoreForm $form
     */
    public function developerProjectFavoriteStore($form)
    {
        $type = $form->type;
        $developer_project_ids = $form->developer_project_ids;
        $developer_project_favorite_repository = new DeveloperProjectFavoriteRepository();
        $user_id = CheckTokenService::getUserId();
        if ($type == DeveloperProjectFavoriteType::COLLECT) {
            $developer_project_favorite_entities = $developer_project_favorite_repository->getFavoriteByUserIdAndProjectId(
                $user_id, $developer_project_ids);
            if ($developer_project_favorite_entities->isEmpty()) {
                foreach ($developer_project_ids as $developer_project_id) {
                    /** @var DeveloperProjectFavoriteEntity $developer_project_favorite_entity */
                    $developer_project_favorite_entity = new DeveloperProjectFavoriteEntity();
                    $developer_project_favorite_entity->user_id = $user_id;
                    $developer_project_favorite_entity->developer_project_id = $developer_project_id;
                    $developer_project_favorite_repository->save($developer_project_favorite_entity);
                }
            }
        } elseif ($type == DeveloperProjectFavoriteType::NNDO) {
            $developer_project_favorite_entities = $developer_project_favorite_repository->getFavoriteByUserIdAndProjectId(
                $user_id, $developer_project_ids);
            if (!$developer_project_favorite_entities->isEmpty()) {
                $developer_project_favorite_ids = [];
                /** @var DeveloperProjectFavoriteEntity $developer_project_favorite_entity */
                foreach ($developer_project_favorite_entities as $developer_project_favorite_entity) {
                    $developer_project_favorite_ids[] = $developer_project_favorite_entity->id;
                }
                $developer_project_favorite_repository->delete($developer_project_favorite_ids);
            }
        }
    }
}

