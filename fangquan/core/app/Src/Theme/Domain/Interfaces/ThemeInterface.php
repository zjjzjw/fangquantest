<?php namespace App\Src\Theme\Domain\Interfaces;


use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Theme\Domain\Model\ThemeSpecification;

interface ThemeInterface extends Repository
{

    /**
     * @param ThemeSpecification $spec
     * @param int                $per_page
     * @return mixed
     */
    public function search(ThemeSpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);

    /**
     * @param int      $type
     * @param int|null $limit
     * @return array|\Illuminate\Support\Collection
     */
    public function getThemeListsByType($type, $limit = null);
}