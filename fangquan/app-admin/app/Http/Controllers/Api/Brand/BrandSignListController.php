<?php namespace App\Admin\Http\Controllers\Api\Brand;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Brand\BrandSignList\BrandSignListDeleteForm;
use App\Admin\Src\Forms\Brand\BrandSignList\BrandSignListStoreForm;
use App\Src\Brand\Infra\Repository\BrandSignListRepository;
use Illuminate\Http\Request;

class BrandSignListController extends BaseController
{
    /**
     * 添加品牌项目清单
     * @param Request                   $request
     * @param BrandSignListStoreForm    $form
     * @param                           $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, BrandSignListStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $brand_sign_list_repository = new BrandSignListRepository();
        $brand_sign_list_repository->save($form->brand_sign_list_entity);
        $data['id'] = $form->brand_sign_list_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改品牌项目清单
     * @param Request                   $request
     * @param BrandSignListStoreForm    $form
     * @param                           $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, BrandSignListStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除品牌项目清单
     * @param Request                    $request
     * @param BrandSignListDeleteForm    $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, BrandSignListDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $brand_sign_list_repository = new BrandSignListRepository();
        $brand_sign_list_repository->delete($id);

        return response()->json($data, 200);
    }
}
