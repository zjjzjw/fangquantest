<?php namespace App\Admin\Http\Controllers\Provider;


use App\Admin\Http\Controllers\BaseController;
use App\Service\Provider\ProviderAduitdetailsService;
use App\Src\Provider\Domain\Model\ProviderAduitdetailsSpecification;
use App\Src\Provider\Domain\Model\ProviderAduitdetailsType;
use App\Admin\Src\Forms\Provider\ProviderAduitdetails\ProviderAduitdetailsSearchForm;
use Illuminate\Http\Request;

/**
 * 验厂报告
 * Class ProviderAduitdetailsController
 * @package App\Admin\Http\Controllers\Provider
 */
class ProviderAduitdetailsController extends BaseController
{
    public function index(Request $request, ProviderAduitdetailsSearchForm $form, $provider_id)
    {

        $data = [];
        $request->merge(['provider_id' => $provider_id]);
        $form->validate($request->all());

        $provider_aduitdetails_service = new ProviderAduitdetailsService();
        $data = $provider_aduitdetails_service->getProviderAduitdetailsList($form->provider_aduitdetails_specification);
        $appends = $this->getAppends($form->provider_aduitdetails_specification);
        $data['provider_id'] = $provider_id;
        $data['appends'] = $appends;
        return $this->view('pages.provider.provider-aduitdetails.index', $data);
    }

    public function edit(Request $request, $provider_id, $id)
    {
        $data = [];
        $provider_aduitdetails_service = new ProviderAduitdetailsService();
        if (!empty($id)) {
            $data = $provider_aduitdetails_service->getProviderAduitdetailsInfo($id);
        }
        $ProviderAduitdetailsType = ProviderAduitdetailsType::acceptableEnums();
        $data['provider_aduitdetails_types'] = $ProviderAduitdetailsType;
        $data['provider_id'] = $provider_id;
        $data['id'] = $id;

        return $this->view('pages.provider.provider-aduitdetails.edit', $data);
    }

    /**
     * @param ProviderAduitdetailsSpecification $pec
     * @return array
     */
    public function getAppends(ProviderAduitdetailsSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }
}
