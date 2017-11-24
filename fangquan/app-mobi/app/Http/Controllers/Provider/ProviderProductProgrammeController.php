<?php

namespace App\Mobi\Http\Controllers\Provider;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Provider\ProviderFriendMobiService;
use App\Mobi\Service\Provider\ProviderProductProgrammeMobiService;
use App\Src\Provider\Domain\Model\ProviderFriendStatus;
use Illuminate\Http\Request;

class ProviderProductProgrammeController extends BaseController
{
    /**
     * 产品组合列表
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function programmeList(Request $request, $id)
    {
        $data = [];
        $provider_product_programme_service = new ProviderProductProgrammeMobiService();
        $provider_product_programme = $provider_product_programme_service->getProviderProductProgrammeByProviderId($id);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $provider_product_programme;
        return response()->json($data, 200);
    }


    /**
     * 产品组合详情
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(Request $request, $id)
    {
        $data = [];

        $provider_product_programme_service = new ProviderProductProgrammeMobiService();
        $provider_product_programme = $provider_product_programme_service->getProviderProductProgrammeById($id);

        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $provider_product_programme;
        return response()->json($data, 200);
    }

}


