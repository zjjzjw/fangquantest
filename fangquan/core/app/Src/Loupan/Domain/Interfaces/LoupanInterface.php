<?php namespace App\Src\Loupan\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Loupan\Domain\Model\LoupanSpecification;

interface loupanInterface extends Repository
{
    /**
     * @param LoupanSpecification $spec
     * @param int                 $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(LoupanSpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);


    /**
     * @param int|array $name
     * @return array|\Illuminate\Support\Collection
     */
    public function getLoupanListByName($name);

    /**
     * @param $keyword
     * @return array|\Illuminate\Support\Collection
     */
    public function getLoupanByKeyword($keyword);

}