<?php

namespace App\Wap\Http\Controllers\Review;

use App\Service\ContentPublish\ContentService;
use App\Wap\Http\Controllers\BaseController;
use App\Wap\Src\Forms\Content\ContentSearchForm;
use Illuminate\Http\Request;

class ReviewController extends BaseController
{
    public function index(Request $request, ContentSearchForm $form)
    {
        $data = [];
        $this->title = '首届房地产创新采购展';
        $this->file_css = 'pages.review.list';
        $this->file_js = 'pages.review.list';
        $content_service = new ContentService();
        $limit = 10; //默认10条
        $data = $content_service->getContentListByType(11, $limit);
        return $this->view('pages.review.list', $data);
    }


    public function detail(Request $request, $id)
    {
        $data = [];
        $this->file_css = 'pages.review.detail';
        $this->file_js = 'pages.review.detail';
        if (!empty($id)) {
            $content_service = new ContentService();
            $data = $content_service->getContentInfo($id);
        }
        return $this->view('pages.review.detail', $data);
    }


}