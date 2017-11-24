<?php

namespace App\Mobi\Http\Controllers\Provider;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Provider\ProviderFavoriteMobiService;
use App\Service\FqUser\CheckTokenService;
use App\Src\Exception\LoginException;
use App\Src\Provider\Domain\Model\ProviderFavoriteEntity;
use App\Src\Provider\Infra\Repository\ProviderFavoriteRepository;
use Illuminate\Http\Request;

class ProviderFavoriteController extends BaseController
{
    public function providerFavorite(Request $request)
    {
        $data = [];
        $result = [];

        if (!CheckTokenService::isLogin()) {
            throw new LoginException('', LoginException::ERROR_NO_LOGIN);
        }
        $user_id = CheckTokenService::getUserId();
        $provider_id = $request->get('provider_id');
        if (!empty($provider_id)) {
            $provider_ids = explode(',', $provider_id);
            $type = $request->get('type');
            $provider_favorite_repository = new ProviderFavoriteRepository();
            if ($type == 1) { //收藏
                $provider_favorite_entities = $provider_favorite_repository->getProviderFavoriteByUserIdAndProviderId(
                    $user_id, $provider_ids
                );

                if ($provider_favorite_entities->isEmpty()) {
                    foreach ($provider_ids as $provider_id) {
                        $provider_favorite_entity = new ProviderFavoriteEntity();
                        $provider_favorite_entity->user_id = $user_id;
                        $provider_favorite_entity->provider_id = $provider_id;
                        $provider_favorite_repository->save($provider_favorite_entity);
                    }
                }
            } else if ($type == 2) { //取消
                $provider_favorite_entities = $provider_favorite_repository->getProviderFavoriteByUserIdAndProviderId(
                    $user_id, $provider_ids
                );
                if (!$provider_favorite_entities->isEmpty()) {
                    $provider_favorite_ids = [];
                    foreach ($provider_favorite_entities as $provider_favorite_entity) {
                        $provider_favorite_ids[] = $provider_favorite_entity->id;
                        $provider_favorite_repository->delete($provider_favorite_ids);
                    }
                }
            }
        }
        $result['success'] = true;
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $result;

        return response()->json($data, 200);
    }


    public function list()
    {
        if (!CheckTokenService::isLogin()) {
            throw new LoginException('', LoginException::ERROR_NO_LOGIN);
        }
        $user_id = CheckTokenService::getUserId();
        $provider_favorite_mobi_service = new ProviderFavoriteMobiService();
        $providers = $provider_favorite_mobi_service->getProviderByUserId($user_id);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $providers;
        return response()->json($data, 200);
    }
}


