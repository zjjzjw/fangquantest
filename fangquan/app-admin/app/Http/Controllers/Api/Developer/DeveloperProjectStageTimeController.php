<?php namespace App\Admin\Http\Controllers\Api\Developer;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Developer\DeveloperProjectStage\DeveloperProjectStageTimeDeleteForm;
use App\Admin\Src\Forms\Developer\DeveloperProjectStage\DeveloperProjectStageTimeStoreForm;
use App\Src\Developer\Domain\Model\DeveloperProjectStageTimeEntity;
use App\Src\Developer\Infra\Repository\DeveloperProjectStageTimeRepository;
use Illuminate\Http\Request;

class DeveloperProjectStageTimeController extends BaseController
{
    /**
     * 添加开发商项目阶段时间
     * @param Request            $request
     * @param DeveloperProjectStageTimeStoreForm $form
     * @param                    $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, DeveloperProjectStageTimeStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $developer_project_stage_time_repository = new DeveloperProjectStageTimeRepository();
        $developer_project_stage_time_repository->save($form->developer_project_stage_time_entity);
        $data['id'] = $form->developer_project_stage_time_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改开发商项目阶段时间
     * @param Request                  $request
     * @param DeveloperProjectStageTimeStoreForm       $form
     * @param                          $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, DeveloperProjectStageTimeStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除开发商项目阶段时间
     * @param Request                    $request
     * @param DeveloperProjectStageTimeDeleteForm        $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, DeveloperProjectStageTimeDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $developer_project_stage_time_repository = new DeveloperProjectStageTimeRepository();
        $developer_project_stage_time_repository->delete($id);

        return response()->json($data, 200);
    }

}
