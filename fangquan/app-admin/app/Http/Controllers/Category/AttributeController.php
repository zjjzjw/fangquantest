<?php namespace App\Admin\Http\Controllers\Category;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Category\AttributeSearchForm;
use App\Service\Category\AttributeService;
use App\Src\Category\Domain\Model\AttributeSpecification;
use App\Service\Category\CategoryService;
use App\Src\Category\Domain\Model\CategoryEntity;
use App\Src\Category\Infra\Repository\CategoryRepository;
use Illuminate\Http\Request;

class AttributeController extends BaseController
{
    public function index(Request $request, AttributeSearchForm $form)
    {
        $data = [];
        $attribute_service = new AttributeService();
        $form->validate($request->all());
        $data = $attribute_service->getAttributeList($form->attribute_specification, 20);
        $appends = $this->getAppends($form->attribute_specification);
        $category_service = new CategoryService();
        $data['category_lists'] = $category_service->getCategoryLists();
        $data['appends'] = $appends;
        return $this->view('pages.attribute.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $data = [];
        $category_service = new CategoryService();
        $attribute_service = new AttributeService();
        if (!empty($id)) {
            $data = $attribute_service->getAttributeInfo($id);
            $category_entity = $category_service->getCategoryInfo($data['category_id']);
            $data['category_name']=$category_entity['name'] ?? '';
        }
        $data['category_lists'] = $category_service->getCategoryLists();
        return $this->view('pages.attribute.edit', $data);
    }

    public function getAppends(AttributeSpecification $spec)
    {
        $appends = [];

        if ($spec->category_id) {
            $appends['category_id'] = $spec->category_id;
        }
        if ($spec->category_type) {
            $appends['category_type'] = $spec->category_type;
        }
        return $appends;
    }
}
