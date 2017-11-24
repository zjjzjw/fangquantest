<?php namespace App\Admin\Http\Controllers\Theme;


use App\Admin\Http\Controllers\BaseController;
use App\Admin\Src\Forms\Theme\ThemeSearchForm;
use App\Service\Theme\ThemeService;
use App\Src\Theme\Domain\Model\ThemeSpecification;
use App\Src\Theme\Domain\Model\ThemeType;
use Illuminate\Http\Request;

class ThemeController extends BaseController
{
    public function index(Request $request, ThemeSearchForm $form)
    {
        $data = [];
        $theme_service = new ThemeService();
        $form->validate($request->all());
        $types = ThemeType::acceptableEnums();
        $data = $theme_service->getThemeList($form->theme_specification, 20);
        $appends = $this->getAppends($form->theme_specification);

        $data['types'] = $types;
        $data['appends'] = $appends;

        return $this->view('pages.theme.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $data = [];
        if (!empty($id)) {
            $theme_service = new ThemeService();
            $data = $theme_service->getThemeInfo($id);
        }
        $data['theme_types'] = ThemeType::acceptableEnums();
        return $this->view('pages.theme.edit', $data);
    }


    /**
     * @param ThemeSpecification $spec
     * @return array
     */
    public function getAppends(ThemeSpecification $spec)
    {
        $appends = [];
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        if ($spec->type) {
            $appends['type'] = $spec->type;
        }

        return $appends;
    }
}
