<?php namespace App\Admin\Http\Controllers\Api\Developer;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Developer\DeveloperProject\DeveloperProjectDeleteForm;
use App\Admin\Src\Forms\Developer\DeveloperProject\DeveloperProjectStoreForm;
use App\Src\Developer\Domain\Model\DeveloperProjectEntity;
use App\Src\Developer\Infra\Repository\DeveloperProjectContactRepository;
use App\Src\Developer\Infra\Repository\DeveloperProjectRepository;
use Illuminate\Http\Request;

class DeveloperProjectController extends BaseController
{
    /**
     * 添加开发商项目
     * @param Request            $request
     * @param DeveloperProjectStoreForm $form
     * @param                    $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, DeveloperProjectStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $developer_project_repository = new DeveloperProjectRepository();
        $developer_project_repository->save($form->developer_project_entity);
        $data['id'] = $form->developer_project_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改开发商项目
     * @param Request                  $request
     * @param DeveloperProjectStoreForm       $form
     * @param                          $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, DeveloperProjectStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除开发商项目
     * @param Request                    $request
     * @param DeveloperProjectDeleteForm        $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, DeveloperProjectDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $developer_project_repository = new DeveloperProjectRepository();
        $developer_project_repository->delete($id);
        $developer_project_contact_repository = new DeveloperProjectContactRepository();
        $developer_project_contact_repository->deleteByDeveloperProjectId($id);
        return response()->json($data, 200);
    }

}
