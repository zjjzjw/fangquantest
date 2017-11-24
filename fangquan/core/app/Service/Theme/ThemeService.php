<?php

namespace App\Service\Theme;


use App\Src\Theme\Domain\Model\ThemeEntity;
use App\Src\Theme\Domain\Model\ThemeSpecification;
use App\Src\Theme\Domain\Model\ThemeType;
use App\Src\Theme\Infra\Repository\ThemeRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ThemeService
{
    /**
     * @param ThemeSpecification $spec
     * @param int                $per_page
     * @return array
     */
    public function getThemeList(ThemeSpecification $spec, $per_page)
    {
        $data = [];
        $theme_repository = new ThemeRepository();
        $paginate = $theme_repository->search($spec, $per_page);
        $theme_type = ThemeType::acceptableEnums();
        $items = [];
        /**
         * @var int                  $key
         * @var ThemeEntity          $theme_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $theme_entity) {
            $item = $theme_entity->toArray();
            $item['type_name'] = $theme_type[$item['type']] ?? '';
            $items[] = $item;
        }
        $data['paginate'] = $paginate;
        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();

        return $data;
    }

    /**
     * @param $id
     * @return array
     */
    public function getThemeInfo($id)
    {
        $data = [];
        $theme_repository = new ThemeRepository();
        /** @var ThemeEntity $theme_entity */
        $theme_entity = $theme_repository->fetch($id);
        if (isset($theme_entity)) {
            $data = $theme_entity->toArray();
        }
        return $data;
    }

    public function getThemeListsByType($type)
    {
        $data = [];
        $theme_repository = new ThemeRepository();
        $theme_entities = $theme_repository->getThemeListsByType($type);
        foreach ($theme_entities as $theme_entity) {
            $item = $theme_entity->toArray();
            $data[] = $item;
        }
        return $data;
    }
}

