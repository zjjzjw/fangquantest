<?php namespace App\Admin\Http\Controllers\Developer;

use App\Admin\Src\Forms\Project\ProjectCategorySearchForm;
use App\Service\Project\ProjectCategoryService;
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
    public function index(Request $request, ProjectCategorySearchForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $project_category_service = new ProjectCategoryService();
        $data['items'] = $project_category_service->getAllDeveloperCategoryTreeList();


        return $this->view('pages.developer.project-category.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $project_category_service = new ProjectCategoryService();
            $data = $project_category_service->getProjectCategoryInfo($id);
        }
        $data['level'] = $request->get('level');
        $data['parent_id'] = $request->get('parent_id');

        return $this->view('pages.developer.project-category.edit', $data);
    }

    public function getAppends(ProjectCategorySpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }

        return $appends;
    }

}
