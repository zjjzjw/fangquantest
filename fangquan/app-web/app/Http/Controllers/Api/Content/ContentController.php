<?php

namespace App\Web\Http\Controllers\Api\Content;

use App\Service\ContentPublish\ContentService;
use App\Web\Http\Controllers\BaseController;

class ContentController extends BaseController
{
    public function getContentList($page)
    {
        $data = [];
        $content_service = new ContentService();
        $skip = ($page - 1) * 15;
        $data = $content_service->getContentListByType(10, 15, $skip);
        return response()->json($data, 200);
    }

}


