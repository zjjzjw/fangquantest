<?php namespace App\Admin\Http\Controllers\Api\Developer;

use App\Admin\Src\Forms\Project\ProjectCategorySearchForm;
use App\Admin\Src\Forms\Project\ProjectCategoryStoreForm;
use App\Admin\Src\Forms\Project\ProjectCategoryDeleteForm;
use App\Service\Project\ProjectCategoryService;
use App\Src\Project\Infra\Repository\ProjectCategoryRepository;
use App\Admin\Http\Controllers\BaseController;
use App\Src\Project\Domain\Model\ProjectCategorySpecification;
use Illuminate\Http\Request;

/**
 * 项目分类
 * Class ProjectCategoryController
 * @package App\Admin\Http\Controllers\Project
 */
class ProjectCategoryController extends BaseController
{
    public function store(Request $request, ProjectCategoryStoreForm $form, $id)
    {
        $data = [];
        $form->validate($request->all());
        $project_category_repository = new ProjectCategoryRepository();
        $project_category_repository->save($form->project_category_entity);
        $data['id'] = $form->project_category_entity->id;
        return response()->json($data, 200);
    }

    public function update(Request $request, ProjectCategoryStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }

}
