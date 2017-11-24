<?php

namespace App\Admin\Http\Controllers\Api;


use App\Admin\Http\Controllers\Controller;
use App\Src\Surport\Domain\Model\ResourceEntity;

use App\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Http\Request;

class QiniuCallbackController extends Controller
{
    public function index()
    {
        $resource_repository = new ResourceRepository();
        $data = $resource_repository->getResourceUrlByIds([1, 2, 3]);
        return response()->json($data);
    }

    public function create(Request $request)
    {
        $data = [];
        $resource_repository = new ResourceRepository();
        if ($request->input('hash')) {
            $resource_entity = $resource_repository->getResourceByHash($request->input('hash'));
            if (!isset($resource_entity)) {
                $resource_entity = new ResourceEntity();
            }
            $resource_entity->bucket = $request->input('bucket');
            $resource_entity->hash = $request->input('hash');
            $resource_entity->mime_type = $request->input('mimeType', '');
            $resource_entity->desc = '';
            $resource_repository->save($resource_entity);

            if ($request->has('origin_id')) {
                $origin_resource_entities = $resource_repository->getResourceUrlByIds([$request->input('origin_id')]);
                if (!empty($origin_resource_entities)) {
                    $origin_resource_entity = current($origin_resource_entities);
                    if (!$origin_resource_entity->processed_hash) {
                        $resource_repository->setProcessedHash($origin_resource_entity, $resource_entity->hash);
                    }
                }
            }
            $data = [
                'id'         => (string)$resource_entity->id,
                'url'        => $resource_entity->url,
                'origin_url' => $resource_entity->url,
            ];

            if ($request->has('fops')) {
                $fops = [$request->input('fops')];
                $data['url'] = $resource_repository->privateUrlWithFop($resource_entity, $fops);
            }
        }
        return response()->json($data);
    }
}