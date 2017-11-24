<?php namespace App\Admin\Http\Controllers\ContentPublish;

use App\Admin\Src\Forms\Content\ContentCategorySearchForm;
use App\Service\Content\ContentCategoryService;
use App\Admin\Http\Controllers\BaseController;
use App\Src\Content\Domain\Model\ContentCategorySpecification;
use App\Src\Content\Domain\Model\ContentCategoryStatus;
use Illuminate\Http\Request;

/**
 * 内容管理
 * Class ContentController
 * @package App\Admin\Http\Controllers\Content
 */
class ContentCategoryController extends BaseController
{
    public function index(Request $request, ContentCategorySearchForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $content_category_service = new ContentCategoryService();
        $data['items'] = $content_category_service->getMainContentCategoryList();
        return $this->view('pages.content-publish.category.index', $data);
    }

    public function edit(Request $request, $parent_id, $id)
    {
        $data = [];
        $content_category_status = ContentCategoryStatus::acceptableEnums();

        if (!empty($id)) {
            $content_category_service = new ContentCategoryService();
            $data = $content_category_service->getContentCategoryInfo($id);
        }
        $data['parent_id'] = $parent_id;
        $data['category_status']=$content_category_status;
        return $this->view('pages.content-publish.category.edit', $data);
    }

    public function getAppends(ContentCategorySpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }

        return $appends;
    }
}
