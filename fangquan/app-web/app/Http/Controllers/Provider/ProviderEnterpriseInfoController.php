<?php

namespace App\Web\Http\Controllers\Provider;

use App\Service\Provider\ProviderCertificateService;
use App\Service\Provider\ProviderPropagandaService;
use App\Web\Service\Provider\ProviderCommonWebService;
use App\Web\Service\Provider\ProviderWebService;
use App\Service\Provider\ProviderFriendService;
use App\Web\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class ProviderEnterpriseInfoController extends BaseController
{
    /**
     * 供应商企业信息
     * @param Request $request
     * @param         $provider_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $provider_id)
    {
        $data = [];
        $provider_propaganda_service = new ProviderPropagandaService();
        $provider_common_service = new ProviderCommonWebService();
        $provider_certificate = new ProviderCertificateService();
        $provider_friend_service = new ProviderFriendService();
        $provider_service = new ProviderWebService();
        $certificate = $provider_certificate->getProviderCertificateByProviderId($provider_id);
        $data = $provider_service->getProviderDetailById($provider_id);
        $provider_propagandas = $provider_propaganda_service->getProviderPropagandaByProviderIdAndStatus($provider_id);
        $provider_friends = $provider_friend_service->getProviderFriendByProviderId($provider_id);
        $common_data = $provider_common_service->getProviderCommonByProviderId($provider_id);

        $data['friends'] = $provider_friends;
        $data['certificate'] = $certificate;
        $data['provider_id'] = $provider_id;
        $data['propagandas'] = $provider_propagandas;
        $data['common_data'] = $common_data;

        return $this->view('pages.provider.enterprise-info', $data);
    }


}