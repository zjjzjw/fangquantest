<?php namespace App\Admin\Http\Controllers\Api\Provider;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Provider\ProviderFriend\ProviderFriendDeleteForm;
use App\Admin\Src\Forms\Provider\ProviderFriend\ProviderFriendStoreForm;
use App\Src\Provider\Domain\Model\ProviderFavoriteEntity;
use App\Src\Provider\Domain\Model\ProviderFriendStatus;
use App\Src\Provider\Infra\Repository\ProviderFriendRepository;
use Illuminate\Http\Request;

class ProviderFriendController extends BaseController
{
    /**
     * 战略合作开发商
     * @param Request                        $request
     * @param  ProviderFriendStoreForm       $form
     * @param                                $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, ProviderFriendStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());

        $provider_friend_repository = new ProviderFriendRepository();
        $provider_friend_repository->save($form->provider_friend_entity);

        $data['id'] = $form->provider_friend_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 战略合作开发商
     * @param Request                       $request
     * @param ProviderFriendStoreForm       $form
     * @param                               $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, ProviderFriendStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 战略合作开发商
     * @param Request                       $request
     * @param ProviderFriendDeleteForm      $form
     * @param                               $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, ProviderFriendDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $provider_friend_repository = new ProviderFriendRepository();
        $provider_friend_repository->delete($id);

        return response()->json($data, 200);
    }

    public function audit(Request $request, $id)
    {
        $data = [];
        $provider_friend_repository = new ProviderFriendRepository();
        /** @var ProviderFavoriteEntity $provider_friend_entity */
        $provider_friend_entity = $provider_friend_repository->fetch($id);
        $provider_friend_entity->status = ProviderFriendStatus::STATUS_PASS;
        $provider_friend_repository->save($provider_friend_entity);
        return response()->json($data, 200);
    }

    public function reject(Request $request, $id)
    {
        $data = [];
        $provider_friend_repository = new ProviderFriendRepository();
        /** @var ProviderFavoriteEntity $provider_friend_entity */
        $provider_friend_entity = $provider_friend_repository->fetch($id);
        $provider_friend_entity->status = ProviderFriendStatus::STATUS_REJECT;
        $provider_friend_repository->save($provider_friend_entity);
        return response()->json($data, 200);
    }
}