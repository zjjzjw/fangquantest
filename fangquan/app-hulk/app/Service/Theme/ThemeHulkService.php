<?php

namespace App\Hulk\Service\Theme;


use App\Src\Theme\Domain\Model\ThemeEntity;
use App\Src\Theme\Infra\Repository\ThemeRepository;

class ThemeHulkService
{
    public function getInformationTopThemes($type, $limit = 3)
    {
        $items = [];
        $theme_repository = new ThemeRepository();
        $theme_entities = $theme_repository->getThemeListsByType($type, $limit);
        /** @var ThemeEntity $theme_entity */
        foreach ($theme_entities as $theme_entity) {
            $item = [];
            $item['id'] = $theme_entity->id;
            $item['name'] = $theme_entity->name;
            $items[] = $item;
        }
        return $items;
    }
}

