<?php

namespace App\Mobi\Http\Controllers\Provider;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Provider\ProviderProductMobiService;
use App\Mobi\Service\Provider\ProviderProjectMobiService;
use App\Src\Provider\Domain\Model\ProviderProductSpecification;
use App\Src\Provider\Domain\Model\ProviderProjectStatus;
use Illuminate\Http\Request;

class ProviderProductController extends BaseController
{
    public function providerProducts(Request $request, $id)
    {
        $data = [];
        //二级分裂
        $product_category_id = $request->get('product_category_id');
        $provider_product_mobi_service = new ProviderProductMobiService();
        $provider_product_specification = new ProviderProductSpecification();
        $provider_product_specification->provider_id = $id;
        $provider_product_specification->second_product_category_id = $product_category_id;
        $provider_product_specification->status = [1, 2, 3];
        $provider_products = $provider_product_mobi_service->getProviderProjectBySpec(
            $provider_product_specification
        );
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $provider_products;
        return response()->json($data, 200);
    }


    public function detail(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_product_mobi_service = new ProviderProductMobiService();
        $provider_product = $provider_product_mobi_service->getProviderProductById($id);
        $data['data'] = $provider_product;
        return response()->json($data, 200);
    }

    public function contrast(Request $request)
    {
        $data = [];
        $ids = $request->get('id');
        $provider_product_mobi_service = new ProviderProductMobiService();
        $provider_products = $provider_product_mobi_service->getProviderProductsByIds($ids);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $provider_products;

        return response()->json($data, 200);
    }
}


