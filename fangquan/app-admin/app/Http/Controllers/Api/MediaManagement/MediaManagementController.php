<?php namespace App\Admin\Http\Controllers\Api\MediaManagement;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\MediaManagement\MediaManagementDeleteForm;
use App\Admin\Src\Forms\MediaManagement\MediaManagementStoreForm;
use App\Src\MediaManagement\Domain\Model\MediaManagementEntity;
use App\Src\MediaManagement\Infra\Repository\MediaManagementRepository;
use Illuminate\Http\Request;

class MediaManagementController extends BaseController
{
    /**
     * 添加媒体
     * @param Request            $request
     * @param MediaManagementStoreForm $form
     * @param                    $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, MediaManagementStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $media_management_repository = new MediaManagementRepository();
        $media_management_repository->save($form->media_management_entity);
        $data['id'] = $form->media_management_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改媒体
     * @param Request                  $request
     * @param MediaManagementStoreForm       $form
     * @param                          $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, MediaManagementStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除媒体
     * @param Request                    $request
     * @param MediaManagementDeleteForm        $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, MediaManagementDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $media_management_repository = new MediaManagementRepository();
        $media_management_repository->delete($id);

        return response()->json($data, 200);
    }

    public function getMediaManagementByKeyword(Request $request)
    {
        $data = [];
        $keyword = $request->get('keyword', '');
        if ($keyword) {
            $media_management_repository = new MediaManagementRepository();
            $media_management_entities = $media_management_repository->getMediaManagementByKeyword($keyword);
            /** @var MediaManagementEntity $media_management_entity */
            foreach ($media_management_entities as $media_management_entity) {
                $item = [];
                $item['id'] = $media_management_entity->id;
                $item['name'] = $media_management_entity->name;
                $data[] = $item;
            }
        }
        return $data;
    }
}
