<?php

namespace App\Wap\Http\Controllers\Provider;

use App\Src\Provider\Domain\Model\ProviderProductSpecification;
use App\Wap\Src\Forms\Provider\ProviderProductSearchForm;
use App\Admin\Http\Controllers\BaseController;
use Illuminate\Http\Request;


/**
 * 供应商产品方案
 * Class ProviderProductController
 * @package App\Admin\Http\Controllers\Provider
 */
class ProviderProductSchemeController extends BaseController
{
    public function productList()
    {
        $data = [];
        return $this->view('pages.provider.product-scheme.product-list', $data);
    }

    public function schemeList()
    {
        $data = [];
        return $this->view('pages.provider.product-scheme.scheme-list', $data);
    }

    public function productDetail()
    {
        $data = [];
        return $this->view('pages.provider.product-scheme.product-detail', $data);
    }

    public function schemeDetail()
    {
        $data = [];
        return $this->view('pages.provider.product-scheme.scheme-detail', $data);
    }

    public function index(Request $request, ProviderProductSearchForm $form, $provider_id)
    {
        $data = [];
        $request->merge(['provider_id' => $provider_id]);
        $form->validate($request->all());


        return $this->view('pages.provider.provider-detail.provider-product.abstract', $data);
    }

    public function info(Request $request, $provider_id, $provider_product_id)
    {
        $data = [];

        return $this->view('pages.provider.provider-detail.provider-product.info', $data);
    }

    public function getAppends(ProviderProductSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        if ($spec->provider_id) {
            $appends['provider_id'] = $spec->provider_id;
        }

        return $appends;
    }

}
