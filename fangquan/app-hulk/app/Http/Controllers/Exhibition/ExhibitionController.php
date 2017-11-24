<?php

namespace App\Hulk\Http\Controllers\Exhibition;

use App\Service\ContentPublish\ContentService;
use App\Service\Developer\DeveloperService;
use App\Service\MediaManagement\MediaManagementService;
use App\Service\Provider\ProviderService;
use App\Src\Content\Domain\Model\ContentEntity;
use App\Src\Content\Infra\Repository\ContentRepository;
use App\Src\Developer\Domain\Model\DeveloperSpecification;
use App\Src\Provider\Domain\Model\ProviderSpecification;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Web\Http\Controllers\BaseController;
use App\Web\Src\Forms\Developer\DeveloperSearchForm;
use App\Web\Src\Forms\Exhibition\MediaManagementSearchForm;
use App\Service\Content\ContentCategoryService;

use App\Src\Content\Domain\Model\ContentSpecification;
use App\Src\Content\Domain\Model\ContentStatus;
use App\Src\Content\Domain\Model\ContentTimingPublishType;
use App\Admin\Src\Forms\Content\ContentSearchForm;
use App\Web\Src\Forms\Provider\ProviderSearchForm;
use Illuminate\Http\Request;


class ExhibitionController extends BaseController
{
    /**
     * 展会概况
     * @param Request           $request
     * @param ContentSearchForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function survey(Request $request, ContentSearchForm $form)
    {
        $data = [];
        $content_repository = new ContentRepository();
        //展会介绍的ID为1
        /** @var ContentEntity $content_entity */
        $content_entity = $content_repository->fetch(1);
        $data['introduce'] = $content_entity->content ?? '';
        //重大活动的ID为2
        $content_entity = $content_repository->fetch(2);
        $data['activity'] = $content_entity->content ?? '';
        //合作媒体机构
        $media_management_service = new MediaManagementService();
        $data['media_list'] = $media_management_service->getMediaManagementByType();

        $content_service = new ContentService();
        //精彩瞬间
        $data['jcsj'] = $content_service->getContentListByType(13, 0);
        //精彩片刻
        $data['jcpk'] = $content_service->getContentListByType(14, 6);
        return response()->json($data, 200);
    }

    public function exhibition()
    {
        $data = [];
        $content_service = new ContentService();
        $data['banners'] = $content_service->getContentListByType(19, 5);
        return response()->json($data, 200);
    }

    /**
     * 展会服务
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function service(Request $request)
    {
        $data = [];
        $content_repository = new ContentRepository();
        //参展日程规划 3
        /** @var ContentEntity $daily_planning_entity */
        $daily_planning_entity = $content_repository->fetch(3);
        $data['daily_planning'] = $daily_planning_entity->content ?? '';

        //展厅布局 4
        /** @var ContentEntity $exhibition_layout_entity */
        $exhibition_layout_entity = $content_repository->fetch(4);
        $data['exhibition_layout'] = $exhibition_layout_entity->content ?? '';

        //参展须知 5
        /** @var ContentEntity $exhibition_notice_entity */
        $exhibition_notice_entity = $content_repository->fetch(5);
        $data['exhibition_notice'] = $exhibition_notice_entity->content ?? '';

        //餐饮交通导览 6
        /** @var ContentEntity $exhibition_tour_entity */
        $exhibition_tour_entity = $content_repository->fetch(6);
        $data['exhibition_tour'] = $exhibition_tour_entity->content ?? '';
        return response()->json($data, 200);
    }

    /**
     * 展会回顾
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function review(Request $request)
    {
        $data = [];
        $content_service = new ContentService();
        $limit = 15;
        $data = $content_service->getContentListByType(11, $limit);
        return response()->json($data, 200);

    }

    /**
     * 展会成果
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function result(Request $request)
    {
        $data = [];
        $content_service = new ContentService();
        $limit = 15;
        $data = $content_service->getContentListByType(12, $limit);
        return response()->json($data, 200);
    }


    /**
     * 内容详情页
     * @param Request $request
     * @param integer $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $content_service = new ContentService();
            $data = $content_service->getContentInfo($id);
        }
        return response()->json($data, 200);
    }

    /**
     * 精彩片刻更多
     * @param int $page 页数
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allAudios($page)
    {
        $data = [];
        $content_service = new ContentService();
        $skip = ($page - 1) * 4;
        //精彩片刻
        $data = $content_service->getContentListByType(14, 4, $skip);
        return response()->json($data, 200);
    }


    /**
     * 展会成果更多
     * @param int $page 页数
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allResult($page)
    {
        $data = [];
        $content_service = new ContentService();
        $skip = ($page - 1) * 6;
        //展会成果
        $data = $content_service->getContentListByType(12, 6, $skip);
        return response()->json($data, 200);
    }

    /**
     * 展会成果更多
     * @param int $page 页数
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allReview($page)
    {
        $data = [];
        $content_service = new ContentService();
        $skip = ($page - 1) * 6;
        //展会成果
        $data = $content_service->getContentListByType(11, 6, $skip);
        return response()->json($data, 200);
    }


}