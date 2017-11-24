<?php namespace App\Admin\Http\Controllers\Developer;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Developer\DeveloperProjectContact\DeveloperProjectContactSearchForm;
use App\Service\Developer\DeveloperProjectContactService;
use App\Src\Developer\Domain\Model\DeveloperProjectContactSpecification;
use App\Src\Developer\Domain\Model\DeveloperProjectContactType;
use Illuminate\Http\Request;

/**
 * 开发商项目联系人
 * Class DeveloperProjectContactController
 * @package App\Admin\Http\Controllers\Developer
 */
class DeveloperProjectContactController extends BaseController
{
    public function index(Request $request, DeveloperProjectContactSearchForm $form, $project_id)
    {
        $data = [];
        $developer_project_contact_service = new DeveloperProjectContactService();
        $request->merge(['developer_project_id' => $project_id]);
        $form->validate($request->all());
        $data = $developer_project_contact_service->getDeveloperProjectContactList($form->developer_project_contact_specification, 20);

        $appends = $this->getAppends($form->developer_project_contact_specification);
        $data['appends'] = $appends;
        $data['project_id'] = $project_id;
        $view = $this->view('pages.developer.developer-project-contact.index', $data);
        return $view;
    }

    public function edit(Request $request, $project_id, $id)
    {
        $data = [];
        if (!empty($id) || !empty($project_id)) {
            $developer_project_contact_service = new DeveloperProjectContactService();
            $data = $developer_project_contact_service->getDeveloperProjectContactInfo($id);
        }
        $data['developer_project_contact_type'] = DeveloperProjectContactType::acceptableEnums();
        $data['project_id'] = $project_id;
        $view = $this->view('pages.developer.developer-project-contact.edit', $data);
        return $view;
    }

    public function getAppends(DeveloperProjectContactSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
            $appends['developer_project_id'] = $spec->developer_project_id;
        }
        return $appends;
    }
}
