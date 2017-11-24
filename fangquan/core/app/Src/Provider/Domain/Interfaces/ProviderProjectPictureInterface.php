<?php namespace app\Src\Provider\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;

interface ProviderProjectPictureInterface extends Repository
{
    /**
     * @param int $project_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProviderProjectPictureByProjectId($project_id);

    /**
     * @param int|array $id
     */
    public function deleteById($id);
}