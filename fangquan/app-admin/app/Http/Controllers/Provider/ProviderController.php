<?php namespace App\Admin\Http\Controllers\Provider;


use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Provider\ProviderSearchForm;
use App\Service\Category\CategoryService;
use App\Service\Provider\ProviderService;
use App\Service\Surport\ProvinceService;
use App\Src\Category\Domain\Model\CategoryStatus;
use App\Src\Category\Infra\Repository\CategoryRepository;
use App\Src\Product\Infra\Repository\ProductCategoryRepository;
use App\Src\Provider\Domain\Model\ProviderAdType;
use App\Src\Provider\Domain\Model\ProviderCompanyType;
use App\Src\Provider\Domain\Model\ProviderDomesticType;
use App\Src\Provider\Domain\Model\ProviderManagementType;
use App\Src\Provider\Domain\Model\ProviderSpecification;
use App\Src\Provider\Domain\Model\ProviderStatus;
use App\Src\Provider\Infra\Repository\ProviderMainCategoryRepository;
use Illuminate\Http\Request;

/**
 * 供应商
 * Class ProviderController
 * @package App\Admin\Http\Controllers\Provider
 */
class ProviderController extends BaseController
{
    public function index(Request $request, ProviderSearchForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $provider_service = new ProviderService();
        $data = $provider_service->getProviderList($form->provider_specification, 20);
        $appends = $this->getAppends($form->provider_specification);
        $data['appends'] = $appends;
        return $this->view('pages.provider.provider.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $data = [];
        $data['id'] = $id;
        $personal_sign_service = new ProviderService();
        if (!empty($id)) {
            $data = $personal_sign_service->getProviderInfo($id);
        }
        //获取主营分类
        $category_service = new CategoryService();
        $main_category = $category_service->getCategoryLists();
        $data['main_category'] = $main_category;

        $province_service = new ProvinceService();
        $areas = $province_service->getProvinceForSearch();

        //得到主营产品
        //得到选中二级分类
        $provider_main_category_repository = new ProviderMainCategoryRepository();
        $provider_main_category_models = $provider_main_category_repository->getProviderMainCategoriesByProviderId($id);
        $product_category_ids = [];
        foreach ($provider_main_category_models as $provider_main_category_model) {
            $product_category_ids[] = $provider_main_category_model->product_category_id;
        }
        $data['product_category_ids'] = $product_category_ids;
        $data['areas'] = $areas;

        //得到主营产品的名称
        $product_category_names = [];
        if (!empty($data['product_category_ids'])) {
            $category_repository = new CategoryRepository();
            $product_category_models = $category_repository->getProductCategoryByIds($data['product_category_ids']);
            $product_category_names = [];
            foreach ($product_category_models as $product_category_model) {
                $product_category_names[] = $product_category_model->name;
            }
        }
        $data['product_category_names'] = $product_category_names;
        $data['provider_ad_type'] = ProviderAdType::acceptableEnums();
        $data['company_types'] = ProviderCompanyType::acceptableEnums();
        $data['provider_management_type'] = ProviderManagementType::acceptableEnums();
        $data['provider_domestic_import'] = ProviderDomesticType::acceptableEnums();
        $data['provider_statuses'] = ProviderStatus::acceptableEnums();
        return $this->view('pages.provider.provider.edit', $data);
    }


    public function getAppends(ProviderSpecification $spec)
    {
        $appends = [];
        if ($spec->provider_id) {
            $appends['provider_id'] = $spec->provider_id;
        }
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }
}
