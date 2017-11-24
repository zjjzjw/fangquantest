<?php

namespace App\Hulk\Http\Controllers\Area;

use App\Hulk\Http\Controllers\BaseController;
use App\Hulk\Service\Area\AreaHulkService;
use App\Hulk\Service\Brand\BrandHulkService;
use App\Hulk\Service\Comment\CommentHulkService;
use App\Hulk\Service\Information\InformationHulkService;
use App\Hulk\Service\Product\ProductHulkService;
use App\Hulk\Src\Forms\Brand\BrandProductSearchForm;
use App\Hulk\Src\Forms\Brand\BrandSearchForm;
use App\Service\Regional\ChinaAreaService;
use App\Src\Brand\Domain\Model\CommentType;
use App\Src\Product\Domain\Model\ProductSpecification;
use Illuminate\Http\Request;

class AreaController extends BaseController
{

    public function index(Request $request)
    {
        $data = [];
        $area_service = new AreaHulkService();
        $data = $area_service->getChinaAreaList();
        return response()->json($data, 200);
    }


}


