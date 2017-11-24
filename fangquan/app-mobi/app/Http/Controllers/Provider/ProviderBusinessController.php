<?php

namespace App\Mobi\Http\Controllers\Provider;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Provider\ProviderBusinessMobiService;
use Illuminate\Http\Request;

class ProviderBusinessController extends BaseController
{
    public function providerBusiness(Request $request, $id)
    {
        $data = [];


        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $provider_projects = $provider_business_mobi_service->getProviderBusinessByProviderId($id);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $provider_projects;
        return response()->json($data, 200);
    }

    /**
     * 基本信息
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function basicInfo(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $project = $provider_business_mobi_service->getProviderBusinessById($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

    /**
     * 股东信息
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function shareholderInfo(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $project = $provider_business_mobi_service->getShareholder($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

    /**
     * 主要人员
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function mainPersonInfo(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $project = $provider_business_mobi_service->getMainPerson($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

    /**
     * 变更记录
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeRecordInfo(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $project = $provider_business_mobi_service->getChangeRecord($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

    /**
     * 融资历史
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function financingHistoryInfo(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $project = $provider_business_mobi_service->getFinancingHistory($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

    /**
     * 核心团队
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function coreTeamInfo(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $project = $provider_business_mobi_service->getCoreTeam($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

    /**
     * 企业业务
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function enterpriseBusinessInfo(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $project = $provider_business_mobi_service->getEnterpriseBusiness($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

    /**
     * 法律诉讼
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function legalProceedingsInfo(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $project = $provider_business_mobi_service->getEegalProceedings($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

    /**
     * 法院公告
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function courtNoticeInfo(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $project = $provider_business_mobi_service->getCourtNotice($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

    /**
     * 失信人
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function dishonestPersonInfo(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $project = $provider_business_mobi_service->getDishonestPersonInfo($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

    /**
     * 被执行人
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function personSubjectedExecutionInfo(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $project = $provider_business_mobi_service->getPersonSubjectedExecution($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

    /**
     * 行政处罚
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function administrativeSanctionInfo(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $project = $provider_business_mobi_service->getAdministrativeSanction($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

    /**
     * 严重违规
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function seriousViolationInfo(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $project = $provider_business_mobi_service->getSeriousViolation($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

    /**
     * 股权出质
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function stockOwnershipInfo(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $project = $provider_business_mobi_service->getStockOwnership($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

    /**
     * 动产抵押
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function chattelMortgageInfo(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $project = $provider_business_mobi_service->getChattelMortgage($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

    /**
     * 欠税公告
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function taxNoticeInfo(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $project = $provider_business_mobi_service->getTaxNotice($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

    /**
     * 经营异常
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function abnormalOperationInfo(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $project = $provider_business_mobi_service->getAbnormalOperation($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

    /**
     * 税务评级
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function taxRatingInfo(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $project = $provider_business_mobi_service->getTaxRating($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

    /**
     * 招投标
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function biddingInfo(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $project = $provider_business_mobi_service->getBidding($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

    /**
     * 购地信息
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function purchaseInformationInfo(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $project = $provider_business_mobi_service->getPurchaseInformation($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

    /**
     *资质证书
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function qualificationCertificateInfo(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $project = $provider_business_mobi_service->getQualificationCertificate($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

    /**
     * 商标信息
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function trademarkInformationInfo(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $project = $provider_business_mobi_service->getTrademarkInformation($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

    /**
     * 专利信息
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function patentInfo(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $provider_business_mobi_service = new ProviderBusinessMobiService();
        $project = $provider_business_mobi_service->getPatent($id);
        $data['data'] = $project;
        return response()->json($data, 200);
    }

}


