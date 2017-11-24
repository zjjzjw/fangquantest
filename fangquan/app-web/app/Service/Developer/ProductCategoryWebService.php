<?php

namespace App\Web\Service\Developer;

use App\Service\Product\ProductCategoryService;
use App\Src\Developer\Domain\Model\DeveloperEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectAirconditionerType;
use App\Src\Developer\Domain\Model\DeveloperProjectCategoryType;
use App\Src\Developer\Domain\Model\DeveloperProjectContactEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectContactType;
use App\Src\Developer\Domain\Model\DeveloperProjectDecorateType;
use App\Src\Developer\Domain\Model\DeveloperProjectElevatorType;
use App\Src\Developer\Domain\Model\DeveloperProjectEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectFavoriteEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectSpecification;
use App\Src\Developer\Domain\Model\DeveloperProjectStageBuildType;
use App\Src\Developer\Domain\Model\DeveloperProjectStageDecorateType;
use App\Src\Developer\Domain\Model\DeveloperProjectStageDesignType;
use App\Src\Developer\Domain\Model\DeveloperProjectStageEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectSteelType;
use App\Src\Developer\Domain\Model\DeveloperProjectType;
use App\Src\Developer\Domain\Model\DeveloperType;
use App\Src\Developer\Infra\Repository\DeveloperProjectCategoryRepository;
use App\Src\Developer\Infra\Repository\DeveloperProjectContactRepository;
use App\Src\Developer\Infra\Repository\DeveloperProjectFavoriteRepository;
use App\Src\Developer\Infra\Repository\DeveloperProjectRepository;
use App\Src\Developer\Infra\Repository\DeveloperProjectStageRepository;
use App\Src\Developer\Infra\Repository\DeveloperRepository;
use App\Src\Product\Domain\Model\ProductCategoryStatus;
use App\Src\Product\Domain\Model\ProductCategoryType;
use App\Src\Surport\Domain\Model\CityEntity;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\CityRepository;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Auth;

class ProductCategoryWebService
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