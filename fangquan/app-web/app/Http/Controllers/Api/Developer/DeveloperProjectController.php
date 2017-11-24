<?php

namespace App\Web\Http\Controllers\Api\Developer;

use App\Service\Developer\DeveloperProjectContactService;
use App\Src\Developer\Domain\Model\DeveloperProjectFavoriteEntity;
use App\Src\Developer\Infra\Repository\DeveloperProjectFavoriteRepository;
use App\Web\Http\Controllers\BaseController;
use App\Web\Src\Forms\Developer\DeveloperProjectContact\DeveloperProjectContactSearchForm;
use Illuminate\Http\Request;

class DeveloperProjectController extends BaseController
{
    /**
     * 收藏
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function collect(Request $request)
    {
        $data = [];
        $developer_project_id = $request->get('id');
        $developer_project_favorite_repository = new DeveloperProjectFavoriteRepository();
        $user_id = $request->user()->id;
        $developer_project_favorite_entities = $developer_project_favorite_repository->getFavoriteByUserIdAndProjectId(
            $user_id, $developer_project_id);
        if ($developer_project_favorite_entities->isEmpty()) {
            /** @var DeveloperProjectFavoriteEntity $developer_project_favorite_entity */
            $developer_project_favorite_entity = new DeveloperProjectFavoriteEntity();
            $developer_project_favorite_entity->user_id = $user_id;
            $developer_project_favorite_entity->developer_project_id = $developer_project_id;
            $developer_project_favorite_repository->save($developer_project_favorite_entity);
        }
        return response()->json($data, 200);
    }

    /**
     * 取消收藏
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(Request $request)
    {
        $data = [];
        $developer_project_id = $request->get('id');
        $user_id = $request->user()->id;
        $developer_project_favorite_repository = new DeveloperProjectFavoriteRepository();
        $developer_project_favorite_entities = $developer_project_favorite_repository->getFavoriteByUserIdAndProjectId(
            $user_id, $developer_project_id);
        if (!$developer_project_favorite_entities->isEmpty()) {
            $developer_project_favorite_ids = [];
            /** @var DeveloperProjectFavoriteEntity $developer_project_favorite_entity */
            foreach ($developer_project_favorite_entities as $developer_project_favorite_entity) {
                $developer_project_favorite_ids[] = $developer_project_favorite_entity->id;
            }
            $developer_project_favorite_repository->delete($developer_project_favorite_ids);
        }
        return response()->json($data, 200);

    }
}