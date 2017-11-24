<?php namespace App\Web\Http\Controllers\Api\Personal\Collection;

use App\Src\Provider\Infra\Repository\ProviderProductFavoriteRepository;
use App\Web\Http\Controllers\BaseController;
use App\Web\Src\Forms\Personal\Collection\ProviderProductFavoriteDeleteForm;
use App\Web\Src\Forms\Personal\Collection\ProviderProductFavoriteStoreForm;
use Illuminate\Http\Request;

class ProviderProductFavoriteController extends BaseController
{
    /**
     * 收藏产品
     * @param Request                           $request
     * @param ProviderProductFavoriteStoreForm         $form
     * @param                                   $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, ProviderProductFavoriteStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $provider_product_favorite_repository = new ProviderProductFavoriteRepository();
        $provider_product_favorite_repository->save($form->provider_product_favorite_entity);
        $data['id'] = $form->provider_product_favorite_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 取消收藏产品
     * @param Request                            $request
     * @param ProviderProductFavoriteDeleteForm         $form
     * @param                                    $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, ProviderProductFavoriteDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $provider_product_favorite_repository = new ProviderProductFavoriteRepository();
        $provider_product_favorite_repository->delete($form->provider_product_id);

        return response()->json($data, 200);
    }

}
