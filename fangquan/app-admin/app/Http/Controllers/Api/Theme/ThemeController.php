<?php namespace App\Admin\Http\Controllers\Api\Theme;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Theme\ThemeDeleteForm;
use App\Admin\Src\Forms\Theme\ThemeStoreForm;
use App\Src\Theme\Infra\Repository\ThemeRepository;
use Illuminate\Http\Request;

class ThemeController extends BaseController
{
    /**
     * 添加标签
     * @param Request            $request
     * @param ThemeStoreForm  $form
     * @param                    $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, ThemeStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $theme_repository = new ThemeRepository();
        $theme_repository->save($form->theme_entity);
        $data['id'] = $form->theme_entity->id;
        return response()->json($data, 200);
    }

    /**
     * 修改标签
     * @param Request                  $request
     * @param ThemeStoreForm        $form
     * @param                          $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, ThemeStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

    /**
     * 删除标签
     * @param Request                    $request
     * @param ThemeDeleteForm         $form
     * @param                            $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, ThemeDeleteForm $form, $id)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $theme_repository = new ThemeRepository();
        $theme_repository->delete($id);

        return response()->json($data, 200);
    }

}
