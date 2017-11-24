<?php

namespace App\Wap\Http\Controllers\Exhibition;

use App\Service\Developer\DeveloperProjectService;
use App\Service\Developer\DeveloperService;
use App\Src\Developer\Domain\Model\DeveloperSpecification;
use App\Src\Developer\Domain\Model\DeveloperProjectBiddingType;
use App\Src\Developer\Domain\Model\DeveloperStatus;
use App\Src\Provider\Domain\Model\ProviderStatus;
use App\Web\Service\Developer\DeveloperProjectWebService;
use App\Wap\Src\Forms\Developer\DeveloperProject\DeveloperProjectSearchForm;
use App\Wap\Src\Forms\Developer\DeveloperSearchForm;
use App\Src\Developer\Domain\Model\DeveloperProjectSpecification;
use App\Src\Developer\Domain\Model\DeveloperProjectStatus;
use App\Service\Project\ProjectCategoryService;
use App\Wap\Http\Controllers\BaseController;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use App\Src\Developer\Domain\Model\DeveloperProjectAdType;
use Illuminate\Http\Request;


class DeveloperController extends BaseController
{
    public function index(Request $request, DeveloperSearchForm $form)
    {
        $this->title = '开发商列表';
        $this->file_css = 'pages.exhibition.developer.index';
        $this->file_js = 'pages.exhibition.developer.index';
        $data = [];
        $request->merge(['status' => DeveloperStatus::YES]);
        $form->validate($request->all());
        $developer_service = new DeveloperService();
        $data = $developer_service->getDeveloperList($form->developer_specification, 20);
        $data['appends'] = $this->getDeveloperAppends($form->developer_specification);
        return $this->view('pages.exhibition.developer.index', $data);
    }


    public function getDeveloperAppends(DeveloperSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }

}


