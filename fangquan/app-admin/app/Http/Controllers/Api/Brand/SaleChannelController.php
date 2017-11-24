<?php namespace App\Admin\Http\Controllers\Api\Brand;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Brand\SaleChannel\SaleChannelDeleteForm;
use App\Admin\Src\Forms\Brand\SaleChannel\SaleChannelModifyForm;
use App\Admin\Src\Forms\Brand\SaleChannel\SaleChannelStoreForm;
use App\Src\Brand\Infra\Repository\SaleChannelRepository;
use Illuminate\Http\Request;

class SaleChannelController extends BaseController
{
    /**
     * 添加品牌销售记录
     * @param Request                   $request
     * @param SaleChannelStoreForm      $form
     * @param                           $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, SaleChannelStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $sale_channel_repository = new SaleChannelRepository();
        $sale_channel_repository->save($form->sale_channel_entity);
        $data['id'] = $form->sale_channel_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改品牌销售记录
     * @param Request                   $request
     * @param SaleChannelStoreForm      $form
     * @param                           $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, SaleChannelStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除品牌销售记录
     * @param Request                    $request
     * @param SaleChannelDeleteForm      $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, SaleChannelDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $sale_channel_repository = new SaleChannelRepository();
        $sale_channel_repository->delete($id);

        return response()->json($data, 200);
    }


    /**
     * @param Request               $request
     * @param SaleChannelModifyForm $form
     */
    public function modify(Request $request, SaleChannelModifyForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $sale_channel_repository = new SaleChannelRepository();
        $sale_channel_repository->modify($form->brand_id, $form->sales);
        return response()->json($data);
    }

}
