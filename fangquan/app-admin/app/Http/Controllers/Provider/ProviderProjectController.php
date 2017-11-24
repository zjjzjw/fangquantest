<?php namespace App\Admin\Http\Controllers\Provider;


use App\Admin\Src\Forms\Provider\ProviderProject\ProviderProjectSearchForm;
use App\Service\Provider\ProviderProjectService;
use App\Admin\Http\Controllers\BaseController;
use App\Service\Surport\MeasureunitService;
use App\Service\Surport\ProvinceService;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderProjectSpecification;
use App\Src\Provider\Domain\Model\ProviderProjectStatus;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use Illuminate\Http\Request;

/**
 * 供应商历史项目
 * Class ProviderController
 * @package App\Admin\Http\Controllers\Provider
 */
class ProviderProjectController extends BaseController
{
    public function index(Request $request, ProviderProjectSearchForm $form, $provider_id)
    {
        $data = [];
        $request->merge(['provider_id' => $provider_id]);
        $form->validate($request->all());

        $provider_project_service = new ProviderProjectService();
        $data = $provider_project_service->getProviderProjectList($form->provider_project_specification, 20);
        $appends = $this->getAppends($form->provider_project_specification);
        $data['provider_id'] = $provider_id;
        $data['appends'] = $appends;

        return $this->view('pages.provider.provider-project.index', $data);
    }

    public function edit(Request $request, $provider_id, $id)
    {
        $data = [];
        $provider_project_service = new ProviderProjectService();
        $measureunit_service = new MeasureunitService();
        $province_service = new ProvinceService();

        if (!empty($id)) {
            $data = $provider_project_service->getProviderProjectInfo($id);
        }
        $provider_measureunit_types = $measureunit_service->getMeasureunitForSelect();
        $areas = $province_service->getProvinceForSearch();

        $data['provider_measureunit_types'] = $provider_measureunit_types;
        $data['provider_id'] = $provider_id;
        $data['areas'] = $areas;
        $data['id'] = $id;

        return $this->view('pages.provider.provider-project.edit', $data);
    }

    public function getAppends(ProviderProjectSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        if ($spec->provider_id) {
            $appends['provider_id'] = $spec->provider_id;
            $provider_repository = new ProviderRepository();
            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($spec->provider_id);
            if (isset($provider_entity)) {
                $appends['company_name'] = $provider_entity->company_name;
            }
        }
        if ($spec->status) {
            $appends['status'] = $spec->status;
        }

        return $appends;
    }

    public function list(Request $request, ProviderProjectSearchForm $form)
    {
        $data = [];
        $form->validate($request->all());

        $provider_project_service = new ProviderProjectService();
        $data = $provider_project_service->getProviderProjectList($form->provider_project_specification, 20);
        $appends = $this->getAppends($form->provider_project_specification);
        $data['appends'] = $appends;
        $data['provider_project_status'] = ProviderProjectStatus::acceptableEnums();
        return $this->view('pages.provider.provider-project.list', $data);
    }

    public function audit(Request $request, $id)
    {
        $provider_project_service = new ProviderProjectService();
        if (!empty($id)) {
            $data = $provider_project_service->getProviderProjectInfo($id);
        }
        $data['id'] = $id;
        return $this->view('pages.provider.provider-project.audit', $data);
    }
}
