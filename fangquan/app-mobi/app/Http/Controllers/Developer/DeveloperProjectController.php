<?php

namespace App\Mobi\Http\Controllers\Developer;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Developer\DeveloperProjectStageMobiService;
use App\Mobi\Service\Product\ProductCategoryMobiService;
use App\Mobi\Service\Surport\ChinaAreaMobiService;
use App\Mobi\Src\Forms\Developer\DeveloperProject\DeveloperProjectSearchForm;
use App\Mobi\Service\Developer\DeveloperProjectMobiService;
use App\Src\Developer\Domain\Model\DeveloperProjectCategoryType;
use App\Src\Developer\Domain\Model\DeveloperProjectStatus;
use Illuminate\Http\Request;

class  DeveloperProjectController extends BaseController
{
    //项目列表
    public function index(Request $request, DeveloperProjectSearchForm $form)
    {
        $data = [];
        $request->merge(['status' => DeveloperProjectStatus::YES]);
        $form->validate($request->all());
        $developer_project_mobi_service = new DeveloperProjectMobiService();
        $items = $developer_project_mobi_service->getDeveloperProjectList($form->developer_project_specification, 20);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $items;
        return response()->json($data, 200);
    }

    //项目详情
    public function detail(Request $request, $id)
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = [];
        if (!empty($id)) {
            $developer_project_mobi_service = new DeveloperProjectMobiService();
            $data['data'] = $developer_project_mobi_service->getDeveloperProjectInfo($id);
        }
        return response()->json($data, 200);
    }

    /**
     * 推荐项目
     * @return \Illuminate\Http\JsonResponse
     */
    public function recommend()
    {
        $data = [];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = [];
        $developer_project_mobi_service = new DeveloperProjectMobiService();
        $data['data'] = $developer_project_mobi_service->getIsAdProject();
        return response()->json($data, 200);
    }

    /**
     * 找项目筛选选项
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectFilterItems()
    {
        $result = [];
        // 项目阶段
        $developer_project_stage_mobi_service = new DeveloperProjectStageMobiService();
        $result["stage"] = $developer_project_stage_mobi_service->getDeveloperProjectStageList();
        $stage_all["project_stage_id"] = 0;
        $stage_all["name"] = "全部";
        array_unshift($result["stage"], $stage_all);

        // 所在区域
        $china_area_mobi_service = new ChinaAreaMobiService();
        $result["area"] = $china_area_mobi_service->getChinaAreaAndAll();

        $area_all['id'] = 0;
        $area_all["provinces"] = [];
        $area_all["name"] = "全国";
        array_unshift($result["area"], $area_all);

        // 项目所需材料
        $project_categories = [];
        $project_categories[] = ['id' => 0, 'name' => '全部'];
        $product_category_mobi_service = new ProductCategoryMobiService();
        $product_category_list = $product_category_mobi_service->getCategoryList();
        foreach ($product_category_list as $key => $value) {
            $product_category['id'] = $value['id'];
            $product_category['name'] = $value['name'];
            $project_categories[] = $product_category;
        }
        $result['project_category'] = $project_categories;
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data["data"] = $result;

        return response()->json($data, 200);
    }
}


