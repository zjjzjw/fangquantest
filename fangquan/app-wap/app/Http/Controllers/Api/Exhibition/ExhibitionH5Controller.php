<?php

namespace App\Wap\Http\Controllers\Api\Exhibition;

use App\Service\ContentPublish\ContentService;
use App\Service\Developer\DeveloperService;
use App\Service\MediaManagement\MediaManagementService;
use App\Service\Provider\ProviderService;
use App\Src\Content\Domain\Model\ContentEntity;
use App\Src\Content\Infra\Repository\ContentRepository;
use App\Src\Developer\Domain\Model\DeveloperSpecification;
use App\Src\Provider\Domain\Model\ProviderSpecification;
use App\Wap\Http\Controllers\BaseController;
use App\Wap\Src\Forms\Developer\DeveloperSearchForm;
use App\Wap\Src\Forms\Exhibition\MediaManagementSearchForm;
use App\Admin\Src\Forms\Content\ContentSearchForm;
use App\Wap\Src\Forms\Provider\ProviderSearchForm;
use Illuminate\Http\Request;


class ExhibitionH5Controller extends BaseController
{

    public function allAudios($page)
    {
        $data = [];
        $content_service = new ContentService();
        $skip = ($page - 1) * 4;
        //精彩片刻
        $data = $content_service->getContentListByType(14, 4, $skip);
        return response()->json($data, 200);
    }


    public function allResult($page)
    {
        $data = [];
        $content_service = new ContentService();
        $skip = ($page - 1) * 6;
        //展会成果
        $data = $content_service->getContentListByType(12, 6, $skip);
        return response()->json($data, 200);
    }


}