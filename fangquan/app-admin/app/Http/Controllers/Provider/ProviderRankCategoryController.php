<?php namespace App\Admin\Http\Controllers\Provider;


use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Provider\ProviderRankCategory\ProviderRankCategorySearchForm;
use App\Service\Product\ProductCategoryService;
use App\Service\Provider\ProviderRankCategoryService;
use App\Src\Product\Domain\Model\ProductCategoryStatus;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderRankCategorySpecification;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use Illuminate\Http\Request;


class ProviderRankCategoryController extends BaseController
{
    public function index(Request $request, ProviderRankCategorySearchForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $provider_rank_category_service = new ProviderRankCategoryService();
        $data = $provider_rank_category_service->getProviderRankCategoryList($form->provider_rank_category_specification, 20);
        $appends = $this->getAppends($form->provider_rank_category_specification);
        $data['appends'] = $appends;
        $product_category_service = new ProductCategoryService();
        $data['product_category'] = $product_category_service->getProductCategoryByLevel(2,ProductCategoryStatus::STATUS_ONLINE);
        return $this->view('pages.provider.provider-rank-category.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $data = [];
        $data['id'] = $id;
        $provider_rank_category_service = new ProviderRankCategoryService();
        if (!empty($id)) {
            $data = $provider_rank_category_service->getProviderRankCategoryInfo($id);
        }
        $product_category_service = new ProductCategoryService();
        $data['product_category'] = $product_category_service->getProductCategoryByLevel(2,ProductCategoryStatus::STATUS_ONLINE);
        return $this->view('pages.provider.provider-rank-category.edit', $data);
    }


    public function getAppends(ProviderRankCategorySpecification $spec)
    {
        $appends = [];
        if ($spec->provider_id) {
            $appends['provider_id'] = $spec->provider_id;
            $provider_repository = new ProviderRepository();
            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($spec->provider_id);
            if (isset($provider_entity)) {
                $appends['company_name'] = $provider_entity->company_name;
            }
        }
        if ($spec->category_id) {
            $appends['category_id'] = $spec->category_id;
        }
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }
}
