<?php namespace App\Admin\Http\Controllers\Api\Advertisement;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Advertisement\AdvertisementDeleteForm;
use App\Admin\Src\Forms\Advertisement\AdvertisementStoreForm;
use App\Src\Advertisement\Infra\Repository\AdvertisementRepository;
use Illuminate\Http\Request;

class AdvertisementController extends BaseController
{
    /**
     * 添加广告
     * @param Request                $request
     * @param AdvertisementStoreForm $form
     * @param                        $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, AdvertisementStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $advertisement_repository = new AdvertisementRepository();
        $advertisement_repository->save($form->advertisement_entity);
        $data['id'] = $form->advertisement_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改广告
     * @param Request                  $request
     * @param AdvertisementStoreForm   $form
     * @param                          $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, AdvertisementStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除广告
     * @param Request                    $request
     * @param AdvertisementDeleteForm    $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, AdvertisementDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $advertisement_repository = new AdvertisementRepository();
        $advertisement_repository->delete($id);

        return response()->json($data, 200);
    }

}
