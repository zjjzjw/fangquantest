<?php namespace App\Admin\Http\Controllers\Brand;


use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Brand\SaleChannel\SaleChannelSearchForm;
use App\Service\Brand\BrandService;
use App\Src\Brand\Domain\Model\SaleChannelType;
use App\Src\Brand\Domain\Model\SaleChannelSpecification;
use App\Service\Brand\SaleChannelService;
use Illuminate\Http\Request;

class SaleChannelController extends BaseController
{

    public function index(Request $request, SaleChannelSearchForm $form, $brand_id)
    {
        $data = [];
        $sale_channel_service = new SaleChannelService();
        $request->merge(['brand_id' => $brand_id]);
        $form->validate($request->all());
        $data = $sale_channel_service->getSaleChannelList($form->sale_channel_specification, 20);
        $brand_service = new BrandService();
        $data['brand_progress'] = $brand_service->getProgress($brand_id);
        $appends = $this->getAppends($form->sale_channel_specification);
        $data['appends'] = $appends;
        $data['brand_id'] = $brand_id;
        $data['sale_channel_type'] = SaleChannelType::acceptableEnums();
        return $this->view('pages.brand.sale-channel.index', $data);
    }


    public function edit(Request $request, $brand_id, $id)
    {
        $data = [];
        if (!empty($brand_id) && !empty($id)) {
            $sale_channel_service = new SaleChannelService();
            $data = $sale_channel_service->getSaleChannelInfo($id);
        }
        $data['sale_channel_types'] = SaleChannelType::acceptableEnums();

        $data['years'] = [
            2010 => "2010年",
            2011 => "2011年",
            2012 => "2012年",
            2013 => "2013年",
            2014 => "2014年",
            2015 => "2015年",
            2016 => "2016年",
            2017 => "2017年（1月-6月）"
        ];
        $data['brand_id'] = $brand_id;
        $brand_service = new BrandService();
        $data['brand_progress'] = $brand_service->getProgress($brand_id);
        return $this->view('pages.brand.sale-channel.edit', $data);
    }

    public function report(Request $request, $brand_id)
    {
        $data = [];
        $years = [
            2010 => "2010年",
            2011 => "2011年",
            2012 => "2012年",
            2013 => "2013年",
            2014 => "2014年",
            2015 => "2015年",
            2016 => "2016年",
            2017 => "2017年（1月-6月）"
        ];
        $sale_channel_service = new SaleChannelService();
        $data['channels'] = $sale_channel_service->getSaleChannelListByYear($years, $brand_id);
        $brand_service = new BrandService();
        $data['brand_progress'] = $brand_service->getProgress($brand_id);
        return $this->view('pages.brand.sale-channel.report', $data);
    }

    public function modify(Request $request, $id)
    {
        $data = [];
        $years = [
            2010 => "2010年",
            2011 => "2011年",
            2012 => "2012年",
            2013 => "2013年",
            2014 => "2014年",
            2015 => "2015年",
            2016 => "2016年",
            2017 => "2017年（1月-6月）"
        ];
        $data['years'] = $years;
        //销售数据
        $sale_channel_service = new SaleChannelService();
        $sales = $sale_channel_service->getSaleChannelForModify($id);
        $data['sales'] = $sales;
        $data['brand_id'] = $id;
        $brand_service = new BrandService();
        $data['brand_progress'] = $brand_service->getProgress($id);
        return $this->view('pages.brand.sale-channel.modify', $data);
    }

    public function getAppends(SaleChannelSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        if ($spec->brand_id) {
            $appends['brand_id'] = $spec->brand_id;
        }
        return $appends;
    }
}

