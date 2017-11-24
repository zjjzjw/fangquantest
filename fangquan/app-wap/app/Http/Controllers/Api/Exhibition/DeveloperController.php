<?php

namespace App\Wap\Http\Controllers\Api\Exhibition;


use App\Service\Developer\DeveloperProjectService;
use App\Service\Developer\DeveloperService;
use App\Src\Developer\Domain\Model\DeveloperSpecification;
use App\Src\Developer\Domain\Model\DeveloperProjectBiddingType;
use App\Web\Service\Developer\DeveloperProjectWebService;
use App\Wap\Src\Forms\Developer\DeveloperProject\DeveloperProjectSearchForm;
use App\Wap\Src\Forms\Developer\DeveloperSearchForm;
use App\Src\Developer\Domain\Model\DeveloperProjectSpecification;
use App\Src\Developer\Domain\Model\DeveloperProjectStatus;
use App\Service\Project\ProjectCategoryService;
use App\Wap\Http\Controllers\BaseController;
use App\Src\Developer\Domain\Model\DeveloperStatus;
use App\Src\Surport\Domain\Model\ProvinceEntity;
use App\Src\Surport\Infra\Repository\ProvinceRepository;
use App\Src\Developer\Domain\Model\DeveloperProjectAdType;
use Illuminate\Http\Request;


class DeveloperController extends BaseController
{

    public function developerListMore(Request $request, DeveloperSearchForm $form,$page)
    {

        $data = [];
        $skip=8;
        $request->merge(['status' => DeveloperStatus::YES]);
        $request->merge(['page' => $page]);
        $request->merge(['skip' => $skip]);

        $form->validate($request->all());
        $developer_service = new DeveloperService();
        $per_page = $request->get('per_page', 12);
        $data = $developer_service->getDeveloperListMore($form->developer_specification, $per_page);
        $appends= $this->getDeveloperAppends($form->developer_specification);
        $appends['per_page'] = $per_page;
        $appends['page'] = $page;
        $data['appends'] = $appends;

        return response()->json($data, 200);
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


