<?php
    namespace App\Web\Http\Controllers\Provider;

    use App\Web\Service\Provider\ProviderCommonWebService;
    use App\Web\Service\Provider\ProviderProjectWebService;
    use App\Web\Src\Forms\Provider\ProviderProjectSearchForm;
    use App\Web\Http\Controllers\BaseController;
    use Illuminate\Http\Request;
    class ProviderHistoryProjectController extends BaseController
    {
     /**
      * 供应商企业信息
      * @param Request                   $request
      * @param ProviderProjectSearchForm $form
      * @param                           $provider_id
      * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
      */
     public function index(Request $request, ProviderProjectSearchForm $form, $provider_id)
     {
         $data = [];
         $request->merge(['provider_id' => $provider_id]);
         $form->validate($request->all());

         $provider_project_service = new ProviderProjectWebService();
         $data = $provider_project_service->getProviderProjectList($form->provider_project_specification, 8);
         $provider_common_service = new ProviderCommonWebService();
         $common_data = $provider_common_service->getProviderCommonByProviderId($provider_id);
         $data['common_data'] = $common_data;

         $data['provider_id'] = $provider_id;

         return $this->view('pages.provider.history-project', $data);
     }

 }