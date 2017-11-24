<?php

namespace App\Web\Http\Controllers\Exhibition;

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
     * 精彩回顾列表页
     * @param Request           $request
     * @param ContentSearchForm $form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function flashbackIndex(Request $request, ContentSearchForm $form)
    {
        $data = [];
        $content_service = new ContentService();
        //精彩瞬间
        $data['jcsj'] = $content_service->getContentListByType(13, 0);
        //精彩片刻
        $data['jcpk'] = $content_service->getContentListByType(14, 6);
        return $this->view('pages.exhibition.flashback.index', $data);
    }

    /**
     * 精彩回顾详情
     * @param Request $request
     * @param integer $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function flashbackDetail(Request $request, $id)
    {
        $data = [];
        $content_service = new ContentService();
        $data = $content_service->getContentInfo($id);
        return $this->view('pages.exhibition.flashback.detail', $data);
    }


    /**
     * 精彩回顾视频详情
     * @param Request $request
     * @param integer $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function flashbackAudio(Request $request, $id)
    {
        $data = [];
        $content_service = new ContentService();
        $data = $content_service->getContentInfo($id);
        return $this->view('pages.exhibition.flashback.audio', $data);
    }


    public function allAudios($skip)
    {
        $data = [];
        $content_service = new ContentService();
        $data = $content_service->getContentListByType(14, 3, $skip);
        return response()->json($data, 200);
    }

    /**
     * 合作机构媒体
     * @param Request                   $request
     * @param MediaManagementSearchForm $form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cooperation(Request $request, MediaManagementSearchForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $media_management_service = new MediaManagementService();
        $data['media_list'] = $media_management_service->getMediaManagementByType();
        return $this->view('pages.exhibition.cooperation', $data);
    }


    /**
     * 展会介绍
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function introduce(Request $request)
    {
        $data = [];
        $content_repository = new ContentRepository();
        //展会介绍的ID为1
        $content_entity = $content_repository->fetch(1);
        $data = $content_entity->toArray();

        return $this->view('pages.exhibition.introduce', $data);
    }


    public function activity(Request $request)
    {
        $data = [];

        $content_repository = new ContentRepository();
        //重大活动的ID为2
        $content_entity = $content_repository->fetch(2);
        $data = $content_entity->toArray();

        return $this->view('pages.exhibition.activity', $data);
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
        return $this->view('pages.exhibition.result', $data);
    }

    /**
     * 展会成果详情
     * @param Request $request
     * @param integer $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resultDetail(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $content_service = new ContentService();
            $data = $content_service->getContentInfo($id);
        }
        return $this->view('pages.exhibition.result-detail', $data);
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


        return $this->view('pages.exhibition.service', $data);
    }

    public function getProviderAppends(ProviderSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }


}