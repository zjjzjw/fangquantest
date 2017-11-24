<?php namespace App\Admin\Http\Controllers\Brand;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Brand\BrandSearchForm;
use App\Admin\Src\Forms\Comment\CommentSearchForm;
use App\Service\Brand\BrandService;
use App\Service\Category\CategoryService;
use App\Service\Comment\CommentService;
use App\Service\Product\ProductCategoryService;
use App\Service\Provider\ProviderService;
use App\Service\Surport\ProvinceService;
use App\Src\Brand\Domain\Model\BrandSpecification;
use App\Src\Brand\Domain\Model\CommentType;
use App\Src\Brand\Infra\Repository\BrandServiceRepository;
use App\Src\Category\Domain\Model\CategoryStatus;
use App\Src\Category\Infra\Repository\CategoryRepository;
use App\Src\Product\Domain\Model\ProductCategoryStatus;
use App\Src\Product\Infra\Repository\ProductCategoryRepository;
use App\Src\Provider\Domain\Model\ProviderAdType;
use App\Src\Provider\Domain\Model\ProviderCompanyType;
use App\Src\Provider\Domain\Model\ProviderDomesticType;
use App\Src\Provider\Domain\Model\ProviderManagementType;
use App\Src\Provider\Domain\Model\ProviderStatus;
use App\Src\Provider\Infra\Repository\ProviderMainCategoryRepository;
use App\Src\Role\Domain\Model\UserType;
use Illuminate\Http\Request;

class BrandController extends BaseController
{

    public function edit(Request $request, $id)
    {
        $data = [];

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

        $brand_service = new BrandService();
        $data['brand_progress'] = $brand_service->getProgress($id);

        $data['id'] = $id;
        $data['provider_id'] = $id;

        $data['provider_ad_type'] = ProviderAdType::acceptableEnums();
        $data['company_types'] = ProviderCompanyType::acceptableEnums();
        $data['provider_management_type'] = ProviderManagementType::acceptableEnums();
        $data['provider_domestic_import'] = ProviderDomesticType::acceptableEnums();
        $data['provider_statuses'] = ProviderStatus::acceptableEnums();

        return $this->view('pages.brand.edit', $data);
    }

    public function comments(Request $request, $pid, CommentSearchForm $form)
    {
        $data = [];
        $comment_service = new CommentService();
        $request->merge(['type' => CommentType::BRAND]);
        if (!empty($pid)) {
            $request->merge(['p_id' => $pid]);
        }
        $form->validate($request->all());
        $data = $comment_service->getCommentList($form->comment_specification, 20);
        return $this->view('pages.brand.comments', $data);
    }

    //战略合作开发商
    public function strategicPartner(Request $request, $id)
    {
        $data = [];
        $brand_service = new BrandService();
        if (!empty($id)) {
            $data = $brand_service->getBrandInfo($id);
        }
        $data['friends'] = $brand_service->getBrandLists();
        $data['id'] = $id;
        return $this->view('pages.brand.strategic-partner', $data);
    }

    public function getAppends(BrandSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }
}
