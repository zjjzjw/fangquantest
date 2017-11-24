<?php namespace App\Admin\Http\Controllers\Api\Brand;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Brand\BrandServiceStoreForm;
use App\Admin\Src\Forms\Brand\ServiceModelStoreForm;
use App\Src\Brand\Infra\Repository\BrandServiceRepository;
use Illuminate\Http\Request;


class BrandServiceController extends BaseController
{
    /**
     * 添加品牌服务
     * @param Request               $request
     * @param BrandServiceStoreForm $form
     * @param                       $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, BrandServiceStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $brand_service_repository = new BrandServiceRepository();
        $brand_service_repository->save($form->brand_service_entity);
        $data['id'] = $form->brand_service_entity->id;
        return response()->json($data, 200);
    }


}
