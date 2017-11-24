<?php

namespace App\Mobi\Http\Controllers\Provider;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Provider\ProviderProductProgrammeFavoriteMobiService;
use App\Service\FqUser\CheckTokenService;
use App\Src\Exception\LoginException;
use App\Src\Provider\Domain\Model\ProductProgrammeFavoriteEntity;
use App\Src\Provider\Infra\Repository\ProductProgrammeFavoriteRepository;
use Illuminate\Http\Request;

class ProviderProductProgrammeFavoriteController extends BaseController
{
    public function providerProductProgrammeFavorite(Request $request)
    {
        $data = [];
        $result = [];
        if (!CheckTokenService::isLogin()) {
            throw new LoginException('', LoginException::ERROR_NO_LOGIN);
        }
        $user_id = CheckTokenService::getUserId();
        $product_programme_id = $request->get('provider_product_programme_id');
        $type = $request->get('type');
        $programme_ids = explode(',', $product_programme_id);
        if (!empty($programme_ids)) {
            $product_programme_favorite_repository = new ProductProgrammeFavoriteRepository();
            if ($type == 1) { //收藏
                $product_programme_favorite_entities = $product_programme_favorite_repository->getProductProgrammeFavoriteByProgrammeIdAndUserId(
                    $user_id, $programme_ids
                );
                if ($product_programme_favorite_entities->isEmpty()) {
                    foreach ($programme_ids as $programme_id) {
                        $product_programme_favorite_entity = new ProductProgrammeFavoriteEntity();
                        $product_programme_favorite_entity->user_id = $user_id;
                        $product_programme_favorite_entity->product_programme_id = $programme_id;
                        $product_programme_favorite_repository->save($product_programme_favorite_entity);
                    }
                }
            } else if ($type == 2) { //取消
                $product_programme_favorite_entities = $product_programme_favorite_repository->getProductProgrammeFavoriteByProgrammeIdAndUserId(
                    $user_id, $programme_ids
                );
                if (!$product_programme_favorite_entities->isEmpty()) {
                    $product_programme_favorite_ids = [];
                    foreach ($product_programme_favorite_entities as $provider_favorite_entity) {
                        $product_programme_favorite_ids[] = $provider_favorite_entity->id;
                        $product_programme_favorite_repository->delete($product_programme_favorite_ids);
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
        $product_programmes_favorite_mobi_service = new ProviderProductProgrammeFavoriteMobiService();
        $product_programmes = $product_programmes_favorite_mobi_service->getProductProgrammeByUserId($user_id);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $product_programmes;
        return response()->json($data, 200);
    }

}


