<?php

namespace App\Hulk\Http\Controllers;

use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Eloquent\AppVersionModel;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Http\Request;

class VersionController extends Controller
{
    public function version(Request $request)
    {
        $data = [];
        $result = [];
        $builder = AppVersionModel::query();
        $params = $request->all();
        $builder->where('device', 1);
        $builder->where('version_code', '>', $params['version_code']);
        $builder->orderBy('id', 'desc');
        $model = $builder->first();
        if (isset($model)) {
            $result = [];
            $result['version_name'] = $model->version_name;
            $result['size'] = $model->size;
            $result['change'] = $model->change;
            $resource_repository = new ResourceRepository();
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($model->resource_id);
            if (isset($resource_entity)) {
                $result['link'] = $resource_repository->getDownloadUrl($resource_entity, ['download/' . $model->version_name . '.apk']);
            }

            if ($model->force_upgrade == 1) {
                $result['force'] = true;
            } else {
                $result['force'] = false;
            }
        }
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $result;

        return response()->json($data, 200);
    }

}