<?php

namespace App\Wap\Http\Controllers\Api\Review;

use App\Service\ContentPublish\ContentService;
use App\Wap\Http\Controllers\BaseController;
use App\Wap\Src\Forms\Content\ContentSearchForm;
use Illuminate\Http\Request;

class ReviewController extends BaseController
{
    public function list($page)
    {
        $content_service = new ContentService();
        $limit = 10; //默认10条
        $skip = ($page - 1) * 10;
        $data = $content_service->getContentListByType(11, $limit, $skip);
        return response()->json($data, 200);
    }


}