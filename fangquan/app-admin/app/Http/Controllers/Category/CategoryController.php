<?php namespace App\Admin\Http\Controllers\Category;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Category\CategorySearchForm;
use App\Service\Category\AttributeService;
use App\Service\Category\CategoryService;
use App\Src\Category\Domain\Model\CategorySpecification;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function index(Request $request)
    {
        $data = [];
        $category_service = new CategoryService();
        $data['items'] = $category_service->getCategoryLists(false);

        return $this->view('pages.category.index', $data);
    }

    public function edit(Request $request, $parent_id, $id)
    {
        $data = [];
        if (!empty($id)) {
            $category_service = new CategoryService();
            $data = $category_service->getCategoryInfo($id);
        }
        $attribute_service = new AttributeService();
        $data['attributes'] = $attribute_service->getAttributeByCategoryId($id);

        $data['parent_id'] = $parent_id;

        return $this->view('pages.category.edit', $data);
    }

}
