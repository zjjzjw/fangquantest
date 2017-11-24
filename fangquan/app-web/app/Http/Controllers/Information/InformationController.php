<?php

namespace App\Web\Http\Controllers\Information;

use App\Service\ContentPublish\ContentService;
use App\Src\Content\Domain\Model\ContentSpecification;
use App\Web\Src\Forms\Content\ContentSearchForm;
use App\Web\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class InformationController extends BaseController
{
    public function index(Request $request, ContentSearchForm $form)
    {
        $data = [];
        $content_service = new ContentService();
        $limit = $request->get('limit');
        $limit = ($limit == 'all') ? 0 : 15;
        $data = $content_service->getContentListByType(10, $limit);
        return $this->view('pages.information.list', $data);
    }

    public function edit(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $content_service = new ContentService();
            $data = $content_service->getContentInfo($id);
        }
        return $this->view('pages.information.detail', $data);
    }

}