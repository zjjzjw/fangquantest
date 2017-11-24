<?php namespace App\Admin\Http\Controllers\Api\Developer;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Developer\Developer\DeveloperDeleteForm;
use App\Admin\Src\Forms\Developer\Developer\DeveloperStoreForm;
use App\Src\Developer\Domain\Model\DeveloperEntity;
use App\Src\Developer\Infra\Repository\DeveloperRepository;
use Illuminate\Http\Request;

class DeveloperController extends BaseController
{
    /**
     * 添加开发商
     * @param Request            $request
     * @param DeveloperStoreForm $form
     * @param                    $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, DeveloperStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $developer_repository = new DeveloperRepository();
        $developer_repository->save($form->developer_entity);
        $data['id'] = $form->developer_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改开发商
     * @param Request                  $request
     * @param DeveloperStoreForm       $form
     * @param                          $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, DeveloperStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除开发商
     * @param Request                    $request
     * @param DeveloperDeleteForm        $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, DeveloperDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $developer_repository = new DeveloperRepository();
        $developer_repository->delete($id);

        return response()->json($data, 200);
    }

    public function getDeveloperByKeyword(Request $request)
    {
        $data = [];
        $keyword = $request->get('keyword', '');
        if ($keyword) {
            $developer_repository = new DeveloperRepository();
            $developer_entities = $developer_repository->getDeveloperByKeyword($keyword);
            /** @var DeveloperEntity $developer_entity */
            foreach ($developer_entities as $developer_entity) {
                $item = [];
                $item['id'] = $developer_entity->id;
                $item['name'] = $developer_entity->name;
                $data[] = $item;
            }
        }
        return $data;
    }
}
