<?php

namespace App\Web\Http\Controllers\Api\Provider;

use App\Web\Service\Provider\ProviderContactWebService;
use App\Web\Http\Controllers\BaseController;
use Illuminate\Http\Request;

/**
 * 获取供应商联系人
 * Class ProviderContactController
 * @package App\Web\Http\Controllers\Api\Provider
 */
class ProviderContactController extends BaseController
{
    public function index(Request $request)
    {
        $data = [];
        $provider_id = $request->get('provider_id');
        $provider_service = new ProviderContactWebService();
        $data = $provider_service->getContactInfoByProviderId($provider_id);

        return response()->json($data, 200);
    }
}