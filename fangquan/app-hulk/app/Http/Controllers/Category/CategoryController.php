<?php

namespace App\Hulk\Http\Controllers\Category;

use App\Hulk\Http\Controllers\BaseController;
use App\Hulk\Service\Category\CategoryHulkService;
use App\Hulk\Service\Theme\ThemeHulkService;
use App\Src\Brand\Domain\Model\BrandCompanyType;
use App\Src\Brand\Domain\Model\BrandType;
use App\Src\Theme\Domain\Model\ThemeType;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function getTopCategory()
    {
        $data = [];
        $category_api_service = new CategoryHulkService();
        $data['category_list'] = $category_api_service->getLevelCategorys(0);
        $theme_api_service = new ThemeHulkService();
        $data['theme_list'] = $theme_api_service->getInformationTopThemes(ThemeType::PRODUCT);
        return response()->json($data, 200);
    }

    public function getSecondCategory(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $category_api_service = new CategoryHulkService();
            $data = $category_api_service->getLevelCategorys($id);
        }
        return response()->json($data, 200);
    }


    public function getCategoryAttribute(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $category_hulk_service = new CategoryHulkService();
            $data = $category_hulk_service->getCategoryAndAttributeInfo($id);
            $data['company_type'] = BrandCompanyType::acceptableEnums();
            $data['product_type'] = BrandType::acceptableEnums();
        }
        return response()->json($data, 200);
    }
}


