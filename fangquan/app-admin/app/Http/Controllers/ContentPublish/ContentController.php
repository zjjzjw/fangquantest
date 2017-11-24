<?php namespace App\Admin\Http\Controllers\ContentPublish;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Content\ContentSearchForm;
use App\Service\Content\ContentCategoryService;
use App\Service\ContentPublish\ContentService;
use App\Src\Content\Domain\Model\ContentSpecification;
use App\Src\Content\Domain\Model\ContentStatus;
use App\Src\Content\Domain\Model\ContentTimingPublishType;
use Illuminate\Http\Request;

class ContentController extends BaseController
{
    public function index(Request $request, ContentSearchForm $form)
    {
        $data = [];
        $developer_service = new ContentService();
        $form->validate($request->all());
        $data = $developer_service->getContentList($form->content_specification, 20);

        $appends = $this->getAppends($form->content_specification);
        $data['appends'] = $appends;
        return $this->view('pages.content-publish.content.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $content_service = new ContentService();
            $data = $content_service->getContentInfo($id);
        }
        $data['content_status'] = ContentStatus::acceptableEnums();
        $data['timing_publish_type'] = ContentTimingPublishType::acceptableEnums();
        $content_category_service = new ContentCategoryService();
        $data['category_tree'] = $content_category_service->getContentCategoryTree();
        return $this->view('pages.content-publish.content.edit', $data);
    }

    public function getAppends(ContentSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }
}
