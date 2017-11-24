<?php namespace App\Admin\Http\Controllers\Api\Provider;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Provider\ProviderCertificate\ProviderCertificateDeleteForm;
use App\Admin\Src\Forms\Provider\ProviderCertificate\ProviderCertificateStoreForm;
use App\Src\Provider\Domain\Model\ProviderCertificateEntity;
use App\Src\Provider\Domain\Model\ProviderCertificateStatus;
use App\Src\Provider\Infra\Repository\ProviderCertificateRepository;
use Illuminate\Http\Request;

class ProviderCertificateController extends BaseController
{
    /**
     * 添加企业证书
     * @param Request                      $request
     * @param ProviderCertificateStoreForm $form
     * @param                              $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, ProviderCertificateStoreForm $form, $id)
    {
        $data = [];
        $request->merge(['status' => ProviderCertificateStatus::STATUS_PASS]);
        $form->validate($request->all());

        $provider_certificate_repository = new ProviderCertificateRepository();
        $provider_certificate_repository->save($form->provider_certificate_entity);

        $data['id'] = $form->provider_certificate_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 更新企业证书
     * @param Request                      $request
     * @param ProviderCertificateStoreForm $form
     * @param                              $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, ProviderCertificateStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除企业证书
     * @param Request                       $request
     * @param ProviderCertificateDeleteForm $form
     * @param                               $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, ProviderCertificateDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $provider_certificate_repository = new ProviderCertificateRepository();
        $provider_certificate_repository->delete($id);

        return response()->json($data, 200);
    }

    public function audit(Request $request, $id)
    {
        $data = [];
        $provider_certificate_repository = new ProviderCertificateRepository();
        /** @var ProviderCertificateEntity $provider_certificate_entity */
        $provider_certificate_entity = $provider_certificate_repository->fetch($id);
        $provider_certificate_entity->status = ProviderCertificateStatus::STATUS_PASS;
        $provider_certificate_repository->save($provider_certificate_entity);
        return response()->json($data, 200);
    }


    public function reject(Request $request, $id)
    {
        $data = [];
        $provider_certificate_repository = new ProviderCertificateRepository();
        /** @var ProviderCertificateEntity $provider_certificate_entity */
        $provider_certificate_entity = $provider_certificate_repository->fetch($id);
        $provider_certificate_entity->status = ProviderCertificateStatus::STATUS_REJECT;
        $provider_certificate_repository->save($provider_certificate_entity);
        return response()->json($data, 200);
    }
}