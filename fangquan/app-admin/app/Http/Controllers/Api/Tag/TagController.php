<?php namespace App\Admin\Http\Controllers\Api\Tag;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Tag\TagDeleteForm;
use App\Admin\Src\Forms\Tag\TagStoreForm;
use App\Src\Tag\Infra\Repository\TagRepository;
use Illuminate\Http\Request;

class TagController extends BaseController
{
    /**
     * 添加关键词
     * @param Request            $request
     * @param TagStoreForm  $form
     * @param                    $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, TagStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $tag_repository = new TagRepository();
        $tag_repository->save($form->tag_entity);
        $data['id'] = $form->tag_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改关键词
     * @param Request                  $request
     * @param TagStoreForm        $form
     * @param                          $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, TagStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除关键词
     * @param Request                    $request
     * @param TagDeleteForm         $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, TagDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $tag_repository = new TagRepository();
        $tag_repository->delete($id);

        return response()->json($data, 200);
    }

}
