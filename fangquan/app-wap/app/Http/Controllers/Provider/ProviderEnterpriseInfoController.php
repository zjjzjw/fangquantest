<?php

namespace App\Wap\Http\Controllers\Provider;


use App\Wap\Http\Controllers\BaseController;
use App\Wap\Service\Provider\ProviderWebService;
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


        return $this->view('pages.provider.enterprise-info', $data);
    }


}