<?php

namespace App\Wap\Service\Developer;

use App\Service\Product\ProductCategoryService;
use App\Src\Product\Domain\Model\ProductCategoryStatus;
use App\Src\Product\Domain\Model\ProductCategoryType;
use Auth;

class ProductCategoryWapService
{


    public function getSearchProductCategories()
    {
        $product_category_service = new ProductCategoryService();
        $product_categories = $product_category_service->getProductCategoryByParentId(
            ProductCategoryType::FURNISHINGS,
            ProductCategoryStatus::STATUS_ONLINE);

        return $product_categories;
    }


}