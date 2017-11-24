<?php namespace App\Web\Http\Controllers\Api\Personal\Collection;

use App\Web\Src\Forms\Personal\Collection\DeveloperProjectFavoriteStoreForm;
use App\Src\Developer\Infra\Repository\DeveloperProjectFavoriteRepository;
use App\Web\Http\Controllers\BaseController;
use App\Web\Src\Forms\Personal\Collection\DeveloperProjectFavoriteDeleteForm;
use Illuminate\Http\Request;

class DeveloperProjectFavoriteController extends BaseController
{
    /**
     * 收藏项目
     * @param Request                           $request
     * @param DeveloperProjectFavoriteStoreForm $form
     * @param                                   $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, DeveloperProjectFavoriteStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $developer_project_favorite_repository = new DeveloperProjectFavoriteRepository();
        $developer_project_favorite_repository->save($form->developer_project_favorite_entity);
        $data['id'] = $form->developer_project_favorite_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 取消收藏项目
     * @param Request                            $request
     * @param DeveloperProjectFavoriteDeleteForm $form
     * @param                                    $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, DeveloperProjectFavoriteDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $developer_project_favorite_repository = new DeveloperProjectFavoriteRepository();
        $developer_project_favorite_repository->delete($form->developer_project_id);

        return response()->json($data, 200);
    }

}
