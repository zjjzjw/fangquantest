<?php namespace App\Src\Developer\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;

interface DeveloperProjectContactVisitLogInterface extends Repository
{
    /**
     * @param $developer_project_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProjectContactVisitLogByProjectId($developer_project_id);


    /**
     * 一个项目自能添加一次记录
     * @param int $developer_project_id
     * @param int $user_id
     * @return array|\Illuminate\Support\Collection
     */
    public function getProjectContractVisitLogByProjectIdAndUserId($developer_project_id, $user_id);

}