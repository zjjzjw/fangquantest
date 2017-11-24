<?php namespace App\Admin\Http\Controllers\Api\Brand;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Brand\BrandCertificate\BrandCertificateDeleteForm;
use App\Admin\Src\Forms\Brand\BrandCertificate\BrandCertificateStoreForm;
use App\Src\Brand\Infra\Repository\BrandCertificateRepository;
use Illuminate\Http\Request;

class BrandCertificateController extends BaseController
{
    /**
     * 添加品牌证书
     * @param Request                   $request
     * @param BrandCertificateStoreForm $form
     * @param                           $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, BrandCertificateStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $brand_certificate_repository = new BrandCertificateRepository();
        $brand_certificate_repository->save($form->brand_certificate_entity);
        $data['id'] = $form->brand_certificate_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改品牌证书
     * @param Request                   $request
     * @param BrandCertificateStoreForm $form
     * @param                           $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, BrandCertificateStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除品牌证书
     * @param Request                    $request
     * @param BrandCertificateDeleteForm $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, BrandCertificateDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $brand_certificate_repository = new BrandCertificateRepository();
        $brand_certificate_repository->delete($id);

        return response()->json($data, 200);
    }
}
