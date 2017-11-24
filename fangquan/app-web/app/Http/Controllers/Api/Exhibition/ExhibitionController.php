<?php

namespace App\Web\Http\Controllers\Api\Exhibition;

use App\Service\ContentPublish\ContentService;
use App\Web\Http\Controllers\BaseController;

class ExhibitionController extends BaseController
{

    public function allAudios($page)
    {
        $data = [];
        $content_service = new ContentService();
        $skip = ($page - 1) * 6;
        //精彩片刻
        $data = $content_service->getContentListByType(14, 6, $skip);
        return response()->json($data, 200);
    }


    public function allResult($page)
    {
        $data = [];
        $content_service = new ContentService();
        $skip = ($page - 1) * 15;
        //展会成果
        $data = $content_service->getContentListByType(12, 15, $skip);
        return response()->json($data, 200);
    }





}