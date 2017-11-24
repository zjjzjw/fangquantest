<?php

namespace App\Web\Http\Controllers\Api\Resource;

use App\Service\ContentPublish\ContentService;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use App\Web\Http\Controllers\BaseController;
use App\Web\Src\Forms\Content\ContentSearchForm;
use Illuminate\Http\Request;

class ResourceController extends BaseController
{
    public function list(Request $request)
    {
        $ids = $request->get('ids');
        $ids = explode(';', $ids);
        $resource_repository = new ResourceRepository();
        $resource_entities = $resource_repository->getResourceUrlByIds($ids);
        $items = [];
        /** @var ResourceEntity $resource_entity */
        foreach ($resource_entities as $resource_entity) {
            $item = [];
            $item['id'] = $resource_entity->id;
            $item['mime_type'] = $resource_entity->mime_type;
            $item['url'] = $resource_entity->url;
            $items[$resource_entity->id] = $item;
        }
        return response()->json($items, 200);
    }

}