<?php namespace App\Admin\Http\Controllers\Api\Content;

use App\Admin\Src\Forms\Content\ContentCategoryStoreForm;
use App\Admin\Src\Forms\Content\ContentCategoryDeleteForm;
use App\Admin\Http\Controllers\BaseController;
use App\Service\Content\ContentCategoryService;
use App\Src\Content\Infra\Repository\ContentCategoryRepository;
use Illuminate\Http\Request;


class ContentCategoryController extends BaseController
{

    public function store(Request $request, ContentCategoryStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $content_category_repository = new ContentCategoryRepository();
        $content_category_repository->save($form->content_category_entity);
        $data['id'] = $form->content_category_entity->id;
        return response()->json($data, 200);
    }

    public function update(Request $request, ContentCategoryStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    public function getNextContentCategory(Request $request, $id)
    {
        $data = [];
        $parent_id = $id;
        if (!empty($parent_id)) {
            $content_category_service = new ContentCategoryService();
            $content_category_entities = $content_category_service->getContentCategoryByParentId($parent_id);
            foreach ($content_category_entities as $content_category_entity) {
                $item = $content_category_entity;
                $data[] = $item;
            }
        }
        return response()->json($data, 200);
    }

    public function delete($id, Request $request, ContentCategoryDeleteForm $form)
    {

        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $content_category_repository = new ContentCategoryRepository();
        $content_category_repository->delete($id);
        return response()->json($data, 200);


    }

}