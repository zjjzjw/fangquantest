<?php namespace App\Web\Http\Controllers\Api\Personal\Collection;

use App\Src\Provider\Infra\Repository\ProductProgrammeFavoriteRepository;
use App\Web\Http\Controllers\BaseController;
use App\Web\Src\Forms\Personal\Collection\ProductProgrammeFavoriteDeleteForm;
use App\Web\Src\Forms\Personal\Collection\ProductProgrammeFavoriteStoreForm;
use Illuminate\Http\Request;

class ProductProgrammeFavoriteController extends BaseController
{
    /**
     * 收藏方案
     * @param Request                           $request
     * @param ProductProgrammeFavoriteStoreForm         $form
     * @param                                   $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, ProductProgrammeFavoriteStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $product_programme_favorite_repository = new ProductProgrammeFavoriteRepository();
        $product_programme_favorite_repository->save($form->product_programme_favorite_entity);
        $data['id'] = $form->product_programme_favorite_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 取消收藏方案
     * @param Request                            $request
     * @param ProductProgrammeFavoriteDeleteForm         $form
     * @param                                    $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, ProductProgrammeFavoriteDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $product_programme_favorite_repository = new ProductProgrammeFavoriteRepository();
        $product_programme_favorite_repository->delete($form->product_programme_id);

        return response()->json($data, 200);
    }

}
