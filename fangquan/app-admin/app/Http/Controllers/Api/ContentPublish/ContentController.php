<?php namespace App\Admin\Http\Controllers\Api\ContentPublish;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Content\ContentDeleteForm;
use App\Admin\Src\Forms\Content\ContentStoreForm;
use App\Src\Content\Infra\Repository\ContentRepository;
use Illuminate\Http\Request;

class ContentController extends BaseController
{
    /**
     * 添加内容
     * @param Request                $request
     * @param ContentStoreForm       $form
     * @param                        $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, ContentStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $content_repository = new ContentRepository();
        $content_repository->save($form->content_entity);
        $data['id'] = $form->content_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改内容
     * @param Request                  $request
     * @param ContentStoreForm         $form
     * @param                          $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, ContentStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除内容
     * @param Request                    $request
     * @param ContentDeleteForm          $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, ContentDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $content_repository = new ContentRepository();
        $content_repository->delete($id);

        return response()->json($data, 200);
    }

}
