<?php namespace App\Admin\Http\Controllers\Information;


use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Comment\CommentSearchForm;
use App\Admin\Src\Forms\Information\InformationSearchForm;
use App\Service\Brand\BrandService;
use App\Service\Category\CategoryService;
use App\Service\Comment\CommentService;
use App\Service\Information\InformationService;
use App\Service\Product\ProductService;
use App\Service\Tag\TagService;
use App\Service\Theme\ThemeService;
use App\Src\Brand\Domain\Model\CommentType;
use App\Src\Information\Domain\Model\InformationPublishStatus;
use App\Src\Information\Domain\Model\InformationSpecification;
use App\Src\Information\Domain\Model\InformationStatus;
use App\Src\Theme\Domain\Model\ThemeType;
use Illuminate\Http\Request;

class InformationController extends BaseController
{
    public function index(Request $request, InformationSearchForm $form)
    {
        $data = [];
        $information_service = new InformationService();
        $form->validate($request->all());
        $data = $information_service->getInformationList($form->information_specification, 20);

        $appends = $this->getAppends($form->information_specification);
        $data['appends'] = $appends;
        return $this->view('pages.information.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $information_service = new InformationService();
            $data = $information_service->getInformationInfo($id);
        }
        $category_service = new CategoryService();
        $data['categorys'] = $category_service->getCategoryLists();

        $tag_service = new TagService();
        $data['tags'] = $tag_service->getTagLists();

        $theme_service = new ThemeService();
        $data['themes'] = $theme_service->getThemeListsByType(ThemeType::INFORMATION);

        $data['information_status'] = InformationStatus::acceptableEnums();
        $data['information_publish_status'] = InformationPublishStatus::acceptableEnums();
        return $this->view('pages.information.edit', $data);
    }


    public function comments(Request $request, $pid, CommentSearchForm $form)
    {
        $data = [];
        $comment_service = new CommentService();
        $request->merge(['type' => CommentType::INFORMATION]);
        if (!empty($pid)) {
            $request->merge(['p_id' => $pid]);
        }
        $form->validate($request->all());
        $data = $comment_service->getCommentList($form->comment_specification, 20);
        return $this->view('pages.information.comments', $data);
    }


    public function getAppends(InformationSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }
}
