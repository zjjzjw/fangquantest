<?php namespace App\Admin\Http\Controllers\Tag;


use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Tag\TagSearchForm;
use App\Service\Category\CategoryService;
use App\Service\Tag\TagService;
use App\Src\Tag\Domain\Model\TagType;
use Illuminate\Http\Request;

class TagController extends BaseController
{
    public function index(Request $request, TagSearchForm $form)
    {
        $data = [];
        $tag_service = new TagService();
        $form->validate($request->all());
        $data = $tag_service->getTagList($form->tag_specification, 20);
        return $this->view('pages.tag.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $tag_service = new TagService();
            $data = $tag_service->getTagInfo($id);
        }
        $data['tag_type'] = TagType::acceptableEnums();
        return $this->view('pages.tag.edit', $data);
    }
}
