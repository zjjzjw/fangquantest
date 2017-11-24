<?php

namespace App\Mobi\Http\Controllers\Developer;

use App\Mobi\Service\Developer\DeveloperProjectFavoriteMobiService;
use App\Mobi\Src\Forms\Developer\DeveloperProjectFavorite\DeveloperProjectFavoriteDeleteForm;
use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Src\Forms\Developer\DeveloperProjectFavorite\DeveloperProjectFavoriteStoreForm;
use App\Service\FqUser\CheckTokenService;
use App\Src\Developer\Domain\Model\DeveloperProjectFavoriteStatus;
use App\Src\Developer\Infra\Repository\DeveloperProjectFavoriteRepository;
use App\Src\Exception\LoginException;
use Illuminate\Http\Request;

class DeveloperProjectFavoriteController extends BaseController
{
    //收藏
    public function projectFavorite(Request $request, DeveloperProjectFavoriteStoreForm $form)
    {
        $data = [];
        if (!CheckTokenService::isLogin()) {
            throw new LoginException('', LoginException::ERROR_NO_LOGIN);
        }
        $form->validate($request->all());
        $developer_project_favorite_mobi_service = new DeveloperProjectFavoriteMobiService();
        $developer_project_favorite_mobi_service->developerProjectFavoriteStore($form);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = ['success' => true];
        return response()->json($data, 200);
    }


    /**
     * 供应商项目收藏列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LoginException
     */
    public function list(Request $request)
    {
        if (!CheckTokenService::isLogin()) {
            throw new LoginException('', LoginException::ERROR_NO_LOGIN);
        }
        $user_id = CheckTokenService::getUserId();
        $developer_project_favorite_mobi_service = new DeveloperProjectFavoriteMobiService();
        $items = $developer_project_favorite_mobi_service->getFavoriteProjectByUserId($user_id);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $items;
        return response()->json($data, 200);
    }
}


