<?php namespace App\Admin\Http\Controllers\Api\Brand;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Brand\BrandCustomProduct\BrandCustomProductDeleteForm;
use App\Admin\Src\Forms\Brand\BrandCustomProduct\BrandCustomProductStoreForm;
use App\Src\Developer\Infra\Repository\DeveloperRepository;
use App\Src\Loupan\Infra\Repository\LoupanRepository;
use App\Src\Brand\Infra\Repository\BrandCustomProductRepository;
use Illuminate\Http\Request;

class BrandCustomProductController extends BaseController
{
    /**
     * 添加定制化
     * @param Request                   $request
     * @param BrandCustomProductStoreForm        $form
     * @param                           $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, BrandCustomProductStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $brand_custom_product_repository = new BrandCustomProductRepository();
        $brand_custom_product_repository->save($form->brand_custom_product_entity);
        $data['id'] = $form->brand_custom_product_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改定制化
     * @param Request                   $request
     * @param BrandCustomProductStoreForm        $form
     * @param                           $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, BrandCustomProductStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除定制化
     * @param Request                    $request
     * @param BrandCustomProductDeleteForm        $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, BrandCustomProductDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $brand_custom_product_repository = new BrandCustomProductRepository();
        $brand_custom_product_repository->delete($id);

        return response()->json($data, 200);
    }



}
