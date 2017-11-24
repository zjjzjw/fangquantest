<?php

namespace App\Web\Http\Controllers\Provider;

use App\Service\Provider\ProviderBusinessService;
use App\Web\Http\Controllers\BaseController;
use App\Web\Service\Provider\ProviderCommonWebService;
use Illuminate\Http\Request;

class ProviderBusinessInfoController extends BaseController
{
    /**
     * 供应商工商信息
     * @param Request $request
     * @param         $provider_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $provider_id)
    {
        $data = [];
        $provider_service = new ProviderBusinessService();
        $data = $provider_service->getProviderBusinessInfo($provider_id);
        $data['provider_id'] = $provider_id;
        $provider_common_service = new ProviderCommonWebService();
        $common_data = $provider_common_service->getProviderCommonByProviderId($provider_id);
        $data['common_data'] = $common_data;



        return $this->view('pages.provider.business-info', $data);
    }


}