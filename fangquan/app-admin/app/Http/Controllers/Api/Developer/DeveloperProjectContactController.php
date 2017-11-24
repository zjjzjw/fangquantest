<?php namespace App\Admin\Http\Controllers\Api\Developer;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Developer\DeveloperProjectContact\DeveloperProjectContactDeleteForm;
use App\Admin\Src\Forms\Developer\DeveloperProjectContact\DeveloperProjectContactStoreForm;
use App\Src\Developer\Domain\Model\DeveloperProjectContactEntity;
use App\Src\Developer\Infra\Repository\DeveloperProjectContactRepository;
use Illuminate\Http\Request;

class DeveloperProjectContactController extends BaseController
{
    /**
     * 添加开发商项目联系人
     * @param Request            $request
     * @param DeveloperProjectContactStoreForm $form
     * @param                    $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, DeveloperProjectContactStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $developer_project_contact_repository = new DeveloperProjectContactRepository();
        $developer_project_contact_repository->save($form->developer_project_contact_entity);
        $data['id'] = $form->developer_project_contact_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改开发商项目联系人
     * @param Request                  $request
     * @param DeveloperProjectContactStoreForm       $form
     * @param                          $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, DeveloperProjectContactStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除开发商项目联系人
     * @param Request                    $request
     * @param DeveloperProjectContactDeleteForm        $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, DeveloperProjectContactDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $developer_project_contact_repository = new DeveloperProjectContactRepository();
        $developer_project_contact_repository->delete($id);

        return response()->json($data, 200);
    }

}
