<?php

namespace App\Web\Http\Controllers\Provider;


use App\Service\Provider\ProviderNewsService;
use App\Web\Http\Controllers\BaseController;
use App\Web\Service\Provider\ProviderCommonWebService;
use App\Web\Src\Forms\Provider\ProviderNewsSearchForm;
use Illuminate\Http\Request;

class ProviderCompanyDynamicController extends BaseController
{
    /**
     * 企业动态
     * @param Request                $request
     * @param ProviderNewsSearchForm $form
     * @param                        $provider_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param $provider_id
     */
    public function index(Request $request, ProviderNewsSearchForm $form, $provider_id)
    {
        $data = [];
        $request->merge(['provider_id' => $provider_id]);
        $form->validate($request->all());

        $provider_new_service = new ProviderNewsService();
        $data = $provider_new_service->getProviderNewsList($form->provider_news_specification);
        $data['common_data'] = $this->getCommonData($provider_id);
        $data['provider_id'] = $provider_id;

        return $this->view('pages.provider.company-dynamic.list', $data);
    }

    public function detail(Request $request, $provider_id, $news_id)
    {
        $data = [];
        $provider_new_service = new ProviderNewsService();
        $data = $provider_new_service->getProviderNewsInfo($news_id);
        $data['common_data'] = $this->getCommonData($provider_id);
        $data['provider_id'] = $provider_id;
        return $this->view('pages.provider.company-dynamic.detail', $data);
    }

    public function getCommonData($provider_id)
    {
        $provider_common_service = new ProviderCommonWebService();
        $common_data = $provider_common_service->getProviderCommonByProviderId($provider_id);
        return $common_data;
    }

}