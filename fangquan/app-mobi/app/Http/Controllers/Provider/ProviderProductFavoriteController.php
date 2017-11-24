<?php

namespace App\Mobi\Http\Controllers\Provider;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Provider\ProviderProductFavoriteMobiService;
use App\Service\FqUser\CheckTokenService;
use App\Src\Exception\LoginException;
use App\Src\Provider\Domain\Model\ProviderProductFavoriteEntity;
use App\Src\Provider\Infra\Repository\ProviderProductFavoriteRepository;
use Illuminate\Http\Request;

class ProviderProductFavoriteController extends BaseController
{
    public function providerProductFavorite(Request $request)
    {
        $data = [];
        $result = [];
        if (!CheckTokenService::isLogin()) {
            throw new LoginException('', LoginException::ERROR_NO_LOGIN);
        }
        $user_id = CheckTokenService::getUserId();
        $product_id = $request->get('provider_product_id');
        $type = $request->get('type');
        $product_ids = explode(',', $product_id);
        if (!empty($product_ids)) {
            $provider_product_favorite_repository = new ProviderProductFavoriteRepository();
            if ($type == 1) { //收藏
                $provider_product_favorite_entities = $provider_product_favorite_repository->getProviderProductFavoriteByUserIdAndProductId(
                    $user_id, $product_ids
                );
                if ($provider_product_favorite_entities->isEmpty()) {
                    foreach ($product_ids as $product_id) {
                        $provider_product_favorite_entity = new ProviderProductFavoriteEntity();
                        $provider_product_favorite_entity->user_id = $user_id;
                        $provider_product_favorite_entity->provider_product_id = $product_id;
                        $provider_product_favorite_repository->save($provider_product_favorite_entity);
                    }
                }
            } else if ($type == 2) { //取消
                $provider_product_favorite_entities = $provider_product_favorite_repository->getProviderProductFavoriteByUserIdAndProductId(
                    $user_id, $product_ids
                );
                if (!$provider_product_favorite_entities->isEmpty()) {
                    $provider_product_favorite_ids = [];
                    foreach ($provider_product_favorite_entities as $provider_favorite_entity) {
                        $provider_product_favorite_ids[] = $provider_favorite_entity->id;
                        $provider_product_favorite_repository->delete($provider_product_favorite_ids);
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
        $provider_product_favorite_mobi_service = new ProviderProductFavoriteMobiService();
        $provider_products = $provider_product_favorite_mobi_service->getProviderProductByUserId($user_id);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $provider_products;
        return response()->json($data, 200);
    }

}


