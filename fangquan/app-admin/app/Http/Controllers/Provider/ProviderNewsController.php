<?php namespace App\Admin\Http\Controllers\Provider;

use App\Admin\Src\Forms\Provider\ProviderNews\ProviderNewsSearchForm;
use App\Admin\Http\Controllers\BaseController;
use App\Service\Provider\ProviderNewsService;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderNewsSpecification;
use App\Src\Provider\Domain\Model\ProviderNewsStatus;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use Illuminate\Http\Request;

/**
 * 供应商企业动态
 * Class ProviderController
 * @package App\Admin\Http\Controllers\Provider
 */
class ProviderNewsController extends BaseController
{
    public function index(Request $request, ProviderNewsSearchForm $form, $provider_id)
    {
        $data = [];
        $request->merge(['provider_id' => $provider_id]);
        $form->validate($request->all());

        $provider_news_service = new ProviderNewsService();
        $data = $provider_news_service->getProviderNewsList($form->provider_news_specification, 20);
        $appends = $this->getAppends($form->provider_news_specification);
        $data['provider_id'] = $provider_id;
        $data['appends'] = $appends;

        return $this->view('pages.provider.provider-news.index', $data);
    }


    public function edit(Request $request, $provider_id, $id)
    {
        $data = [];
        $provider_news_service = new ProviderNewsService();
        if (!empty($id)) {
            $data = $provider_news_service->getProviderNewsInfo($id);
        }
        $data['provider_id'] = $provider_id;
        $data['id'] = $id;
        return $this->view('pages.provider.provider-news.edit', $data);
    }

    public function getAppends(ProviderNewsSpecification $spec)
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

    public function list(Request $request, ProviderNewsSearchForm $form)
    {
        $data = [];
        $form->validate($request->all());

        $provider_news_service = new ProviderNewsService();
        $data = $provider_news_service->getProviderNewsList($form->provider_news_specification, 20);
        $appends = $this->getAppends($form->provider_news_specification);
        $data['appends'] = $appends;
        $data['provider_news_status'] = ProviderNewsStatus::acceptableEnums();
        return $this->view('pages.provider.provider-news.list', $data);
    }

    public function audit(Request $request, $id)
    {
        $data = [];
        $provider_news_service = new ProviderNewsService();
        if (!empty($id)) {
            $data = $provider_news_service->getProviderNewsInfo($id);
        }
        $data['id'] = $id;

        return $this->view('pages.provider.provider-news.audit', $data);
    }
}
