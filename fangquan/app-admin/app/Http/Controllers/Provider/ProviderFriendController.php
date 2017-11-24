<?php namespace App\Admin\Http\Controllers\Provider;


use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Provider\ProviderFriend\ProviderFriendSearchForm;
use App\Service\Provider\ProviderFriendService;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderFriendSpecification;
use App\Src\Provider\Domain\Model\ProviderFriendStatus;
use App\Src\Provider\Domain\Model\ProviderSpecification;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use Illuminate\Http\Request;

/**
 * 战略合作
 * Class ProviderFriendController
 * @package App\Admin\Http\Controllers\Provider
 */
class ProviderFriendController extends BaseController
{
    public function index(Request $request, ProviderFriendSearchForm $form, $provider_id)
    {
        $data = [];
        $request->merge(['provider_id' => $provider_id]);
        $form->validate($request->all());

        $provider_friend_service = new ProviderFriendService();
        $data = $provider_friend_service->getProviderFriendList($form->provider_friend_specification);
        $appends = $this->getAppends($form->provider_friend_specification);
        $data['provider_id'] = $provider_id;
        $data['appends'] = $appends;
        return $this->view('pages.provider.provider-friend.index', $data);
    }

    public function edit(Request $request, $provider_id, $id)
    {
        $data = [];
        $provider_Friend_service = new ProviderFriendService();
        if (!empty($id)) {
            $data = $provider_Friend_service->getProviderFriendInfo($id);
        }

        $ProviderFriendType = ProviderFriendStatus::acceptableEnums();
        $data['provider_friend_status'] = $ProviderFriendType;
        $data['provider_id'] = $provider_id;
        $data['id'] = $id;
        return $this->view('pages.provider.provider-friend.edit', $data);
    }

    /**
     * @param ProviderFriendSpecification $spec
     * @return array
     */
    public function getAppends(ProviderFriendSpecification $spec)
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

    public function list(Request $request, ProviderFriendSearchForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $provider_friend_service = new ProviderFriendService();
        $data = $provider_friend_service->getProviderFriendList($form->provider_friend_specification, 20);
        $appends = $this->getAppends($form->provider_friend_specification);
        $data['appends'] = $appends;
        $data['provider_friend_status'] = ProviderFriendStatus::acceptableEnums();
        return $this->view('pages.provider.provider-friend.list', $data);
    }

    public function audit(Request $request, $id)
    {
        $data = [];
        $provider_friend_service = new ProviderFriendService();
        if (!empty($id)) {
            $data = $provider_friend_service->getProviderFriendInfo($id);
        }

        $provider_friend_type = ProviderFriendStatus::acceptableEnums();
        $data['provider_friend_status'] = $provider_friend_type;
        $data['id'] = $id;
        return $this->view('pages.provider.provider-friend.audit', $data);
    }
}
