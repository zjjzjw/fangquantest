<?php namespace App\Admin\Http\Controllers\Advertisement;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Advertisement\AdvertisementSearchForm;
use App\Service\Advertisement\AdvertisementService;
use App\Src\Advertisement\Domain\Model\AdvertisementSpecification;
use App\Src\Advertisement\Domain\Model\AdvertisementStatus;
use Illuminate\Http\Request;

/**
 * 广告
 * Class AdvertisementController
 * @package App\Admin\Http\Controllers\Advertisement
 */
class AdvertisementController extends BaseController
{
    public function index(Request $request, AdvertisementSearchForm $form)
    {
        $data = [];
        $developer_service = new AdvertisementService();
        $form->validate($request->all());
        $data = $developer_service->getAdvertisementList($form->advertisement_specification, 20);

        $appends = $this->getAppends($form->advertisement_specification);
        $data['appends'] = $appends;
        $view = $this->view('pages.advertisement.index', $data);
        return $view;
    }

    public function edit(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $advertisement_service = new AdvertisementService();
            $data = $advertisement_service->getAdvertisementInfo($id);
        }
        $data['advertisement_status'] = AdvertisementStatus::acceptableEnums();
        $view = $this->view('pages.advertisement.edit', $data);
        return $view;
    }

    public function getAppends(AdvertisementSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }
}
