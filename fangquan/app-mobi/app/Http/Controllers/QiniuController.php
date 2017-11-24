<?php

namespace App\Mobi\Http\Controllers;

use App\Src\Surport\Infra\Repository\ResourceRepository;

class QiniuController extends Controller
{

    public function storageToken()
    {
        $data = [];
        $resource_repository = new ResourceRepository();
        $token = $resource_repository->uploadToken(env('STORAGE_QINIU_DEFAULT_BUCKET'));
        $data['code'] = 200;
        $data['msg'] = 'success';
        $result = ['access_token' => $token];
        $data['data'] = $result;
        return response()->json($data, 200);
    }

}