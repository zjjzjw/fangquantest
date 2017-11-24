<?php namespace App\Admin\Http\Controllers\Api\FqUser;

use App\Admin\Src\Forms\FqUser\FqUser\FqUserStoreForm;
use App\Admin\Src\Forms\FqUser\FqUser\FqUserRelevanceForm;
use App\Src\FqUser\Domain\Model\FqUserEntity;
use App\Src\FqUser\Infra\Repository\FqUserRepository;
use App\Src\FqUser\Domain\Model\FqUserPlatformType;
use App\Src\FqUser\Domain\Model\FqUserRegisterType;
use App\Admin\Http\Controllers\BaseController;
use App\Service\FqUser\FqUserService;
use Illuminate\Http\Request;
use DB;

class FqUserController extends BaseController
{
    public function store(Request $request, FqUserStoreForm $form, $id)
    {
        DB::beginTransaction();
        $data = [];
        $request->merge(['register_type_id' => FqUserRegisterType::ACCOUNT]);
        $request->merge(['platform_id' => FqUserPlatformType::TYPE_ADMIN]);
        $form->validate($request->all());
        $fq_user_repository = new FqUserRepository();
        $fq_user_repository->save($form->fq_user_entity);
        DB::commit();
        $data['id'] = $form->fq_user_entity->id;

        return response()->json($data, 200);
    }

    public function update(Request $request, FqUserStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    public function setPassword(Request $request, $id)
    {
        $data = [];
        $fq_user_repository = new FqUserRepository();
        /** @var FqUserEntity $fq_user_entity */
        $fq_user_entity = $fq_user_repository->fetch($id);
        $fq_user_entity->password = $request->get('password');

        $fq_user_repository->updatePassword($fq_user_entity);

        return response()->json($data, 200);
    }

    public function getFqUserName(Request $request)
    {
        $data = [];
        $fq_user_repository = new FqUserRepository();
        $fq_user_entities = $fq_user_repository->getFqUsersByMobile($request->get('keyword'));
        /** @var FqUserEntity $fq_user_entity */
        foreach ($fq_user_entities as $fq_user_entity) {
            $item['id'] = $fq_user_entity->id;
            $item['name'] = $fq_user_entity->account;
            $item['mobile'] = $fq_user_entity->mobile;
            $data[] = $item;
        }
        return response()->json($data, 200);
    }

    public function relevanceProvider(Request $request, FqUserRelevanceForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $fq_user_repository = new FqUserRepository();
        $fq_user_repository->save($form->fq_user_entity);
        $data['id'] = $form->fq_user_entity->id;

        return response()->json($data, 200);
    }
}