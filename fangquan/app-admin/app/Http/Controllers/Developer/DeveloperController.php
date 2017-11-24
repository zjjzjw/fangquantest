<?php namespace App\Admin\Http\Controllers\Developer;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Developer\Developer\DeveloperSearchForm;
use App\Service\Developer\DeveloperService;
use App\Src\Developer\Domain\Model\DeveloperSpecification;
use App\Src\Developer\Domain\Model\DeveloperStatus;
use Illuminate\Http\Request;

/**
 * 开发商
 * Class DeveloperController
 * @package App\Admin\Http\Controllers\Developer
 */
class DeveloperController extends BaseController
{
    public function index(Request $request, DeveloperSearchForm $form)
    {
        $data = [];
        $developer_service = new DeveloperService();
        $form->validate($request->all());
        $data = $developer_service->getDeveloperList($form->developer_specification, 20);

        $appends = $this->getAppends($form->developer_specification);
        $data['appends'] = $appends;
        $data['developer_status'] = DeveloperStatus::acceptableEnums();
        $view = $this->view('pages.developer.developer.index', $data);
        return $view;
    }

    public function edit(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $developer_service = new DeveloperService();
            $data = $developer_service->getDeveloperInfo($id);
        }
        $data['developer_status'] = DeveloperStatus::acceptableEnums();
        $view = $this->view('pages.developer.developer.edit', $data);
        return $view;
    }

    public function getAppends(DeveloperSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        if ($spec->status) {
            $appends['status'] = $spec->status;
        }
        return $appends;
    }
}
