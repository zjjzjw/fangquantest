<?php

namespace App\Wap\Http\Controllers\Provider;

use App\Admin\Http\Controllers\BaseController;
use App\Wap\Src\Forms\Provider\ProviderSearchForm;
use Illuminate\Http\Request;


class ProviderListController extends BaseController
{
    /**
     * 供应商列表
     * @param Request            $request
     * @param ProviderSearchForm $form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, ProviderSearchForm $form)
    {
        $data = [];


        return $this->view('pages.provider.list', $data);
    }


}
