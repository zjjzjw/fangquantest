<?php

namespace App\Web\Http\Controllers\Review;

use App\Service\ContentPublish\ContentService;
use App\Src\Content\Domain\Model\ContentSpecification;
use App\Web\Http\Controllers\BaseController;
use App\Web\Src\Forms\Content\ContentSearchForm;
use Illuminate\Http\Request;

class ReviewController extends BaseController
{
    public function index(Request $request, ContentSearchForm $form)
    {
        $data = [];
        $content_service = new ContentService();
        $limit =  15;
        $data = $content_service->getContentListByType(11, $limit);
        return $this->view('pages.review.list', $data);
    }

    public function detail(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $content_service = new ContentService();
            $data = $content_service->getContentInfo($id);
        }
        return $this->view('pages.review.detail', $data);
    }


}