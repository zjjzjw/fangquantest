<?php namespace App\Admin\Http\Controllers\Api\Brand;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Brand\BrandFactory\BrandFactoryDeleteForm;
use App\Admin\Src\Forms\Brand\BrandFactory\BrandFactoryStoreForm;
use App\Src\Brand\Infra\Repository\BrandFactoryRepository;
use Illuminate\Http\Request;

class BrandFactoryController extends BaseController
{
    /**
     * 添加品牌厂家
     * @param Request                   $request
     * @param BrandFactoryStoreForm     $form
     * @param                           $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, BrandFactoryStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $brand_factory_repository = new BrandFactoryRepository();
        $brand_factory_repository->save($form->brand_factory_entity);
        $data['id'] = $form->brand_factory_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改品牌厂家
     * @param Request                   $request
     * @param BrandFactoryStoreForm     $form
     * @param                           $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, BrandFactoryStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除品牌厂家
     * @param Request                    $request
     * @param BrandFactoryDeleteForm     $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, BrandFactoryDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $brand_factory_repository = new BrandFactoryRepository();
        $brand_factory_repository->delete($id);

        return response()->json($data, 200);
    }
}
