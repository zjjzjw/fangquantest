<?php

namespace App\Mobi\Http\Controllers\Provider;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Provider\ProviderProjectMobiService;
use App\Mobi\Service\Provider\ProviderServiceNetworkMobiService;
use App\Src\Provider\Domain\Model\ProviderProjectStatus;
use App\Src\Provider\Domain\Model\ProviderServiceNetworkSpecification;
use App\Src\Provider\Domain\Model\ProviderServiceNetworkStatus;
use Illuminate\Http\Request;

class ProviderServiceNetworkController extends BaseController
{
    public function providerServiceNetworks(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_service_network_mobi_service = new ProviderServiceNetworkMobiService();
        $provider_service_networks = $provider_service_network_mobi_service->getProviderServiceNetworkByProviderIdAndStatus(
            $id, ProviderServiceNetworkStatus::STATUS_PASS
        );
        $data['data'] = $provider_service_networks;
        return response()->json($data, 200);
    }


    public function list(Request $request)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_service_network_mobi_service = new ProviderServiceNetworkMobiService();
        $provider_service_network_specification = new ProviderServiceNetworkSpecification();
        $provider_service_network_specification->provider_id = $request->get('provider_id');
        $provider_service_network_specification->province_id = $request->get('province_id');
        $provider_service_network_specification->status = ProviderServiceNetworkStatus::STATUS_PASS;
        $provider_service_networks = $provider_service_network_mobi_service->getProviderServiceNetworkBySpec(
            $provider_service_network_specification
        );
        $data['data'] = $provider_service_networks;
        return response()->json($data, 200);
    }

}


