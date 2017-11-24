<?php namespace App\Admin\Http\Controllers\Provider;


use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Provider\ProviderProduct\ProviderProductSearchForm;
use App\Service\Product\ProductCategoryService;
use App\Service\Provider\ProviderProductService;
use App\Src\Product\Domain\Model\ProductCategoryStatus;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderProductSpecification;
use App\Src\Provider\Domain\Model\ProviderProductStatus;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use Illuminate\Http\Request;


/**
 * 供应商产品
 * Class ProviderProductController
 * @package App\Admin\Http\Controllers\Provider
 */
class ProviderProductController extends BaseController
{
    public function index(Request $request, ProviderProductSearchForm $form, $provider_id)
    {
        $data = [];
        $request->merge(['provider_id' => $provider_id]);
        $form->validate($request->all());
        $provider_product_service = new ProviderProductService();
        $data = $provider_product_service->getProviderProductList($form->provider_product_specification, 20);
        $appends = $this->getAppends($form->provider_product_specification);
        $data['appends'] = $appends;
        $data['provider_id'] = $provider_id;

        return $this->view('pages.provider.provider-product.index', $data);
    }

    public function edit(Request $request, $provider_id, $id)
    {
        $data = [];
        if (!empty($id)) {
            $provider_product_service = new ProviderProductService();
            $data = $provider_product_service->getProviderProductInfo($id);
        }
        $provider_product_service = new ProviderProductService();
        $category_ids = $provider_product_service->getProviderMainCategory($provider_id);
        $product_categories = [];
        if (!empty($category_ids)) {
            $product_category_service = new ProductCategoryService();
            $product_categories = $product_category_service->getProductCategoryListByIdsAndLevel(
                $category_ids, ProductCategoryStatus::STATUS_ONLINE
            );
            //默认值处理
            $data['attrib'] = $data['attrib']  ?? [];
            $data['product_category_id'] = $data['product_category_id'] ?? 0;
            $product_categories = $provider_product_service->overlapAttribForCategoies($data['attrib'], $data['product_category_id'], $product_categories);
        }
        $data['product_categories'] = $product_categories;
        $data['provider_id'] = $provider_id;
        $data['id'] = $id;
        return $this->view('pages.provider.provider-product.edit', $data);
    }

    /**
     * @param ProviderProductSpecification $spec
     * @return array
     */
    public function getAppends(ProviderProductSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        if ($spec->provider_id) {
            $appends['provider_id'] = $spec->provider_id;
            $provider_repository = new ProviderRepository();
            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($spec->provider_id);
            if (isset($provider_entity)) {
                $appends['company_name'] = $provider_entity->company_name;
            }
        }
        if ($spec->status) {
            $appends['status'] = $spec->status;
        }

        return $appends;
    }

    public function list(Request $request, ProviderProductSearchForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $provider_product_service = new ProviderProductService();
        $data = $provider_product_service->getProviderProductList($form->provider_product_specification, 20);
        $appends = $this->getAppends($form->provider_product_specification);
        $data['appends'] = $appends;
        $data['provider_product_status'] = ProviderProductStatus::acceptableEnums();
        return $this->view('pages.provider.provider-product.list', $data);
    }

    public function audit(Request $request, $id)
    {
        if (!empty($id)) {
            $provider_product_service = new ProviderProductService();
            $data = $provider_product_service->getProviderProductInfo($id);
        }
        $data['id'] = $id;
        return $this->view('pages.provider.provider-product.audit', $data);
    }
}
