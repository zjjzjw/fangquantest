<?php

namespace App\Wap\Http\Controllers\Exhibition;

use App\Service\ContentPublish\ContentService;
use App\Service\Developer\DeveloperService;
use App\Service\MediaManagement\MediaManagementService;
use App\Service\Provider\ProviderService;
use App\Src\Content\Domain\Model\ContentEntity;
use App\Src\Content\Infra\Repository\ContentRepository;
use App\Src\Developer\Domain\Model\DeveloperSpecification;
use App\Src\Provider\Domain\Model\ProviderSpecification;
use App\Wap\Http\Controllers\BaseController;
use App\Wap\Src\Forms\Developer\DeveloperSearchForm;
use App\Wap\Src\Forms\Exhibition\MediaManagementSearchForm;
use App\Admin\Src\Forms\Content\ContentSearchForm;
use App\Wap\Src\Forms\Provider\ProviderSearchForm;
use Illuminate\Http\Request;


class ExhibitionH5Controller extends BaseController
{

    public function index(Request $request)
    {
        $data = [];
        $this->title = '首届房地产创新采购展';
        $this->file_css = 'pages.exhibition.exhibition-h5.exhibition-h5';
        $this->file_js = 'pages.exhibition.exhibition-h5.exhibition-h5';
        return $this->view('pages.exhibition.exhibition-h5.exhibition-h5', $data);
    }


    //展会概况
    public function flashbackIndex(Request $request, ContentSearchForm $form)
    {
        $data = [];
        $this->title = '首届房地产创新采购展';
        $this->file_css = 'pages.exhibition.flashback.index';
        $this->file_js = 'pages.exhibition.flashback.index';

        $content_service = new ContentService();
        //精彩瞬间
        $data['jcsj'] = $content_service->getContentListByType(13, 0); //$limit 0 标识不限制
        //精彩片刻
        $data['jcpk'] = $content_service->getContentListByType(14, 4);

        $content_repository = new ContentRepository();
        //展会介绍
        /** @var ContentEntity $introduce_content_entity */
        $introduce_content_entity = $content_repository->fetch(1);
        $data['introduce'] = $introduce_content_entity->content ?? '';

        //重大活动
        /** @var ContentEntity $activity_content_entity */
        $activity_content_entity = $content_repository->fetch(2);
        $data['activity'] = $activity_content_entity->content ?? '';

        $media_management_service = new MediaManagementService();
        $data['media_list'] = $media_management_service->getMediaManagementByType();

        return $this->view('pages.exhibition.flashback.index', $data);
    }


    public function flashbackDetail(Request $request, $id)
    {
        $data = [];
        $content_service = new ContentService();
        $data = $content_service->getContentInfo($id);
        return $this->view('pages.exhibition.flashback.detail', $data);
    }

    public function flashbackAudio(Request $request, $id)
    {
        $data = [];
        $this->title = '首届房地产创新采购展';
        $this->file_css = 'pages.exhibition.flashback.audio';
        $this->file_js = 'pages.exhibition.flashback.audio';

        $content_service = new ContentService();
        $data = $content_service->getContentInfo($id);
        return $this->view('pages.exhibition.flashback.audio', $data);
    }


    public function result(Request $request)
    {
        $data = [];
        $this->title = '首届房地产创新采购展';
        $this->file_css = 'pages.exhibition.result';
        $this->file_js = 'pages.exhibition.result';
        $content_service = new ContentService();
        $limit = 6;
        //展会成果
        $data = $content_service->getContentListByType(12, $limit);
        return $this->view('pages.exhibition.result', $data);
    }

    public function resultDetail(Request $request, $id)
    {
        $data = [];
        $this->file_css = 'pages.exhibition.result-detail';
        if (!empty($id)) {
            $content_service = new ContentService();
            $data = $content_service->getContentInfo($id);
        }
        return $this->view('pages.exhibition.result-detail', $data);
    }

    public function providerList(Request $request, ProviderSearchForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $provider_service = new ProviderService();
        $data = $provider_service->getExProviderList($form->provider_specification, 21);
        $data['appends'] = $this->getProviderAppends($form->provider_specification);
        return $this->view('pages.exhibition.provider-list', $data);
    }

    public function developerList(Request $request, DeveloperSearchForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $developer_service = new DeveloperService();
        $data = $developer_service->getDeveloperList($form->developer_specification, 21);
        $data['appends'] = $this->getDeveloperAppends($form->developer_specification);
        return $this->view('pages.exhibition.developer-list', $data);
    }

    //展会服务
    public function service(Request $request)
    {
        $data = [];
        $this->title = '首届房地产创新采购展';
        $this->file_css = 'pages.exhibition.service';
        $this->file_js = 'pages.exhibition.service';

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


    public function getDeveloperAppends(DeveloperSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
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