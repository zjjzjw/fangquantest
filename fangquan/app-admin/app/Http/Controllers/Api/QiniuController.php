<?php

namespace App\Admin\Http\Controllers\Api;

use App\Admin\Http\Controllers\Controller;
use App\Src\Surport\Infra\Repository\ResourceRepository;

class QiniuController extends Controller
{

    public function actionStorageTokens()
    {
        $resource_repository = new ResourceRepository();
        $token = $resource_repository->uploadToken(env('STORAGE_QINIU_DEFAULT_BUCKET'));
        $result = ["items" => [0 => $token]];
        return response()->json($result);
    }

}