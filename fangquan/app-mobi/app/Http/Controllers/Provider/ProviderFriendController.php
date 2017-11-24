<?php

namespace App\Mobi\Http\Controllers\Provider;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Provider\ProviderFriendMobiService;
use App\Mobi\Service\Provider\ProviderNewsMobiService;
use App\Src\Provider\Domain\Model\ProviderFriendStatus;
use App\Src\Provider\Domain\Model\ProviderNewsStatus;
use Illuminate\Http\Request;

class ProviderFriendController extends BaseController
{
    public function providerFriends(Request $request, $id)
    {
        $data = [];
        $provider_friend_mobi_service = new ProviderFriendMobiService();
        $provider_friends = $provider_friend_mobi_service->getProviderFriendByProviderIdAndStatus(
            $id,
            ProviderFriendStatus::STATUS_PASS
        );
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $provider_friends;
        return response()->json($data, 200);
    }


    public function detail(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';

        return response()->json($data, 200);
    }

}


