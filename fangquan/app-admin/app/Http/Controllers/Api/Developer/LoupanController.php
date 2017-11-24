<?php namespace App\Admin\Http\Controllers\Api\Developer;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Loupan\LoupanDeleteForm;
use App\Admin\Src\Forms\Loupan\LoupanStoreForm;
use App\Src\Loupan\Domain\Model\LoupanEntity;
use App\Src\Loupan\Infra\Repository\LoupanRepository;
use App\Src\Developer\Infra\Repository\DeveloperRepository;
use Illuminate\Http\Request;

class LoupanController extends BaseController
{
    /**
     * 添加楼盘名称
     * @param Request            $request
     * @param LoupanStoreForm    $form
     * @param                    $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, LoupanStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $loupan_repository = new LoupanRepository();
        $loupan_repository->save($form->loupan_entity);
        $data['id'] = $form->loupan_entity->id;

        return response()->json($data, 200);
    }

    /**
     * 修改楼盘名称
     * @param Request                  $request
     * @param LoupanStoreForm          $form
     * @param                          $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, LoupanStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除楼盘名称
     * @param Request                    $request
     * @param LoupanDeleteForm           $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, LoupanDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $loupan_repository = new LoupanRepository();
        $loupan_repository->delete($id);
        return response()->json($data, 200);
    }

    public function getDeveloperByKeyword(Request $request)
    {
        $data = [];
        $keyword = $request->get('keyword', '');
        if ($keyword) {
            $developer_repository = new DeveloperRepository();
            $developer_models = $developer_repository->getDeveloperByKeyword($keyword);

            foreach ($developer_models as $key => $value) {

                $item = [];
                $item['id'] = $value->id;
                $item['name'] = $value->name;
                $data[] = $item;
            }
        }
        return response()->json($data, 200);
    }

    public function getLoupanByKeyword(Request $request)
    {
        $data = [];
        $keyword = $request->get('keyword', '');
        if ($keyword) {
            $loupan_repository = new LoupanRepository();
            $loupan_models = $loupan_repository->getLoupanByKeyword($keyword);
            foreach ($loupan_models as $key => $value) {
                $item = [];
                $item['id'] = $value->id;
                $item['name'] = $value->name;
                $item['province_id'] = $value->province_id;
                $item['city_id'] = $value->city_id;
                $data[] = $item;
            }
        }
        return response()->json($data, 200);
    }

}
