<?php

namespace App\Web\Http\Controllers\Api\Review;

use App\Service\ContentPublish\ContentService;
use App\Web\Http\Controllers\BaseController;

class ReviewController extends BaseController
{
    public function reviewList($page)
    {
        $data = [];
        $content_service = new ContentService();
        $skip = ($page - 1) * 15;
        $data = $content_service->getContentListByType(11, 15, $skip);
        return response()->json($data, 200);
    }



}