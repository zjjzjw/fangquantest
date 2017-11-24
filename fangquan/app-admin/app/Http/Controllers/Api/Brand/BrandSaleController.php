<?php namespace App\Admin\Http\Controllers\Api\Brand;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Brand\BrandSale\BrandSaleDeleteForm;
use App\Admin\Src\Forms\Brand\BrandSale\BrandSaleStoreForm;
use App\Src\Brand\Infra\Repository\BrandSaleRepository;
use Illuminate\Http\Request;

class BrandSaleController extends BaseController
{
    /**
     * 添加品牌销售
     * @param Request                   $request
     * @param BrandSaleStoreForm        $form
     * @param                           $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, BrandSaleStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $brand_sale_repository = new BrandSaleRepository();
        $brand_sale_repository->save($form->brand_sale_entity);
        $data['id'] = $form->brand_sale_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改品牌销售
     * @param Request                   $request
     * @param BrandSaleStoreForm        $form
     * @param                           $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, BrandSaleStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除品牌销售
     * @param Request                    $request
     * @param BrandSaleDeleteForm        $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, BrandSaleDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $brand_sale_repository = new BrandSaleRepository();
        $brand_sale_repository->delete($id);

        return response()->json($data, 200);
    }
}
