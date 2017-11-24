<?php namespace App\Admin\Http\Controllers\Api\Brand;

use App\Admin\Http\Controllers\BaseController;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use Illuminate\Http\Request;

class BrandController extends BaseController
{

    public function keyword(Request $request)
    {
        $data = [];
        $keyword = $request->get('keyword');
        if ($keyword) {
            $provider_repository = new ProviderRepository();
            $provider_entities = $provider_repository->getProviderByKeyword($keyword);
            /** @var ProviderEntity $provider_entity */
            foreach ($provider_entities as $provider_entity) {
                $brand = $provider_entity->toArray();
                $item['id'] = $brand['id'];
                $item['name'] = $brand['brand_name'];
                $data[] = $item;
            }
        }
        return response()->json($data, 200);
    }


}
