<?php namespace App\Admin\Http\Controllers\MediaManagement;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\MediaManagement\MediaManagementSearchForm;
use App\Service\MediaManagement\MediaManagementService;
use App\Src\MediaManagement\Domain\Model\MediaManagementSpecification;
use App\Src\MediaManagement\Domain\Model\MediaManagementType;
use Illuminate\Http\Request;

/**
 * 媒体
 * Class MediaManagementController
 * @package App\Admin\Http\Controllers\MediaManagement
 */
class MediaManagementController extends BaseController
{
    public function index(Request $request, MediaManagementSearchForm $form)
    {
        $data = [];
        $media_management_service = new MediaManagementService();
        $form->validate($request->all());
        $data = $media_management_service->getMediaManagementList($form->media_management_specification, 20);
        $appends = $this->getAppends($form->media_management_specification);
        $data['appends'] = $appends;
        $data['media_management_types'] = MediaManagementType::acceptableEnums();
        return $this->view('pages.media-management.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $media_management_service = new MediaManagementService();
            $data = $media_management_service->getMediaManagementInfo($id);
        }
        $data['media_management_types'] = MediaManagementType::acceptableEnums();
        return $this->view('pages.media-management.edit', $data);
    }

    public function getAppends(MediaManagementSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        if ($spec->type) {
            $appends['status'] = $spec->type;
        }
        return $appends;
    }
}
