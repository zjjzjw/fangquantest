<?php

namespace App\Wap\Http\Controllers\Api\Exhibition;

use App\Service\Provider\ProviderService;
use App\Src\Provider\Domain\Model\ProviderSpecification;
use App\Wap\Http\Controllers\BaseController;
use App\Src\Category\Domain\Model\CategoryEntity;
use App\Wap\Service\Provider\ProviderWapService;
use App\Wap\Src\Forms\Provider\ProviderSearchForm;
use Illuminate\Http\Request;


class ProviderController extends BaseController
{
    public function providerListMore(Request $request, ProviderSearchForm $form)
    {
        $data = [];
        $this->title = '供应商列表';
        $this->file_css = 'pages.exhibition.provider.index';
        $this->file_js = 'pages.exhibition.provider.index';

        $form->validate($request->all());
        $per_page = $request->get('per_page', 10);
        $provider_wap_service = new ProviderWapService();
        $data = $provider_wap_service->getProviderList($form->provider_specification, 10);

        $appends = $this->getProviderAppends($form->provider_specification);
        $appends['per_page'] = $per_page;
        $appends['page'] = $data['page']['current_page'] ?? 1;
        $data['appends'] = $appends;

        return response()->json($data, 200);
    }

    public function getProviderAppends(ProviderSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        if ($spec->product_category_id) {
            $appends['product_category_id'] = $spec->product_category_id;
        }
        if ($spec->user_id) {
            $appends['keyword'] = $spec->user_id;
        }
        if ($spec->status) {
            $appends['status'] = $spec->status;
        }
        return $appends;
    }


}
