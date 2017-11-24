<?php

namespace App\Hulk\Http\Controllers\Information;

use App\Hulk\Http\Controllers\BaseController;
use App\Hulk\Service\Comment\CommentHulkService;
use App\Hulk\Service\Information\InformationHulkService;
use App\Hulk\Service\Theme\ThemeHulkService;
use App\Hulk\Src\Forms\Information\InformationSearchForm;
use App\Src\Brand\Domain\Model\CommentType;
use App\Src\Information\Domain\Model\InformationStatus;
use App\Src\Theme\Domain\Model\ThemeType;
use Illuminate\Http\Request;

class InformationController extends BaseController
{
    public function index(Request $request, InformationSearchForm $form)
    {
        $data = [];
        $request->merge(['status' => InformationStatus::YES]);
        $form->validate($request->all());
        $information_api_service = new InformationHulkService();
        $data['information'] = $information_api_service->getInformationList($form->information_specification, 10);
        $theme_api_service = new ThemeHulkService();
        $data['theme_list'] = $theme_api_service->getInformationTopThemes(ThemeType::INFORMATION);

        return response()->json($data, 200);
    }


    public function detail(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $information_api_service = new InformationHulkService();
            $comment_api_service = new CommentHulkService();

            $data = $information_api_service->getInformationInfo($id);
            $data['comments'] = $comment_api_service->getCommentListByPidAndType($id, CommentType::INFORMATION);
        }
        return response()->json($data, 200);
    }

    public function theme()
    {
        $data = [];
        $theme_api_service = new ThemeHulkService();
        $data = $theme_api_service->getInformationTopThemes(ThemeType::INFORMATION, 20);
        return response()->json($data, 200);
    }
}


