<?php namespace App\Admin\Http\Controllers\Api\Information;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Information\InformationDeleteForm;
use App\Admin\Src\Forms\Information\InformationStoreForm;
use App\Service\Information\InformationService;
use App\Src\Information\Infra\Repository\InformationRepository;
use Illuminate\Http\Request;

class InformationController extends BaseController
{
    /**
     * 添加文章
     * @param Request              $request
     * @param InformationStoreForm $form
     * @param                      $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, InformationStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $information_repository = new InformationRepository();
        $information_repository->save($form->information_entity);
        $data['id'] = $form->information_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改文章
     * @param Request                  $request
     * @param InformationStoreForm     $form
     * @param                          $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, InformationStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除文章
     * @param Request                    $request
     * @param InformationDeleteForm      $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, InformationDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $information_repository = new InformationRepository();
        $information_repository->delete($id);

        return response()->json($data, 200);
    }

    /**
     * @param Request $request
     * @param         $id
     */
    public function processImage(Request $request, $id)
    {
        $data = [];
        $information_service = new InformationService();
        $information_service->processContentImage($id);
        $data['id'] = $id;
        return response()->json($data, 200);
    }

}
