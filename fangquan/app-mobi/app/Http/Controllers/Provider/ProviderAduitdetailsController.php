<?php

namespace App\Mobi\Http\Controllers\Provider;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Provider\ProviderAduitdetailsMobiService;
use App\Mobi\Service\Provider\ProviderProjectMobiService;
use App\Mobi\Service\Provider\ProviderServiceNetworkMobiService;
use App\Src\Provider\Domain\Model\ProviderProjectStatus;
use App\Src\Provider\Domain\Model\ProviderServiceNetworkSpecification;
use App\Src\Provider\Domain\Model\ProviderServiceNetworkStatus;
use Illuminate\Http\Request;

class ProviderAduitdetailsController extends BaseController
{
    public function list(Request $request)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_aduitdetails_mobi_service = new ProviderAduitdetailsMobiService();
        $provider_id = $request->get('provider_id');
        $provider_service_aduitdetails = $provider_aduitdetails_mobi_service->getProviderAduitdetailsByProviderId($provider_id);
        $data['data'] = $provider_service_aduitdetails;
        return response()->json($data, 200);
    }

    /**
     * 获取验厂报告详情
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(Request $request, $id)
    {
        $data = [];
        $provider_aduitdetails_mobi_service = new ProviderAduitdetailsMobiService();
        $provider_service_aduitdetails = $provider_aduitdetails_mobi_service->getProviderAduitdetailsById($id);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $provider_service_aduitdetails;

        return response()->json($data, 200);
    }

}


