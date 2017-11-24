<?php namespace App\Web\Http\Controllers\Api\Personal\Collection;

use App\Src\Provider\Infra\Repository\ProviderFavoriteRepository;
use App\Web\Http\Controllers\BaseController;
use App\Web\Src\Forms\Personal\Collection\ProviderFavoriteDeleteForm;
use App\Web\Src\Forms\Personal\Collection\ProviderFavoriteStoreForm;
use Illuminate\Http\Request;

class ProviderFavoriteController extends BaseController
{
    /**
     * 收藏供应商
     * @param Request                           $request
     * @param ProviderFavoriteStoreForm         $form
     * @param                                   $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, ProviderFavoriteStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $provider_favorite_repository = new ProviderFavoriteRepository();
        $provider_favorite_repository->save($form->provider_favorite_entity);
        $data['id'] = $form->provider_favorite_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 取消收藏供应商
     * @param Request                            $request
     * @param ProviderFavoriteDeleteForm         $form
     * @param                                    $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, ProviderFavoriteDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $provider_favorite_repository = new ProviderFavoriteRepository();
        $provider_favorite_repository->delete($form->provider_id);

        return response()->json($data, 200);
    }

}
