<?php

namespace App\Web\Http\Controllers\Provider;

use App\Service\Provider\ProviderServiceNetworkService;
use App\Service\Surport\ProvinceService;
use App\Web\Service\Provider\ProviderCommonWebService;
use App\Web\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class ProviderServiceNetworkController extends BaseController
{
    /**
     * 服务网点
     * @param Request $request
     * @param         $provider_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param $provider_id
     */
    public function index(Request $request, $provider_id)
    {
        $data = [];
        $provider_common_service = new ProviderCommonWebService();
        $provider_service_network_service = new ProviderServiceNetworkService();
        $province_service = new ProvinceService();
        $common_data = $provider_common_service->getProviderCommonByProviderId($provider_id);
        $provider_service_network = $provider_service_network_service->getProviderServiceNetworkByProviderId($provider_id);
        $cities = $province_service->getServiceCities();

        $data['provider_id'] = $provider_id;
        $data['cities'] = $cities;
        $data['service_network_data'] = $provider_service_network;
        $data['common_data'] = $common_data;

        return $this->view('pages.provider.service-network', $data);

    }

}