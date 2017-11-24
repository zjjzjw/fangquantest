<?php namespace App\Admin\Http\Controllers\Api\Brand;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Brand\BrandCooperation\BrandCooperationDeleteForm;
use App\Admin\Src\Forms\Brand\BrandCooperation\BrandCooperationStoreForm;
use App\Src\Brand\Infra\Repository\BrandCooperationRepository;
use Illuminate\Http\Request;

class BrandCooperationController extends BaseController
{
    /**
     * 添加品牌合作客户
     * @param Request                   $request
     * @param BrandCooperationStoreForm $form
     * @param                           $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, BrandCooperationStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $brand_cooperation_repository = new BrandCooperationRepository();
        $brand_cooperation_repository->save($form->brand_cooperation_entity);
        $data['id'] = $form->brand_cooperation_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改品牌合作客户
     * @param Request                   $request
     * @param BrandCooperationStoreForm $form
     * @param                           $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, BrandCooperationStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除品牌合作客户
     * @param Request                    $request
     * @param BrandCooperationDeleteForm $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, BrandCooperationDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $brand_cooperation_repository = new BrandCooperationRepository();
        $brand_cooperation_repository->delete($id);

        return response()->json($data, 200);
    }
}
