<?php

namespace App\Mobi\Http\Controllers\Provider;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Provider\ProviderNewsMobiService;
use App\Src\Provider\Domain\Model\ProviderNewsStatus;
use Illuminate\Http\Request;

class ProviderNewsController extends BaseController
{
    public function providerNews(Request $request, $id)
    {
        $data = [];
        $provider_news_mobi_service = new ProviderNewsMobiService();
        $provider_news = $provider_news_mobi_service->getProviderNewsByProviderIdAndStatus(
            $id,
            ProviderNewsStatus::STATUS_PASS);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $provider_news;

        return response()->json($data, 200);
    }


    public function detail(Request $request, $id)
    {
        $provider_news_mobi_service = new ProviderNewsMobiService();
        $provider_new = $provider_news_mobi_service->getProviderNewsById($id);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $provider_new;

        return response()->json($data, 200);
    }

}


