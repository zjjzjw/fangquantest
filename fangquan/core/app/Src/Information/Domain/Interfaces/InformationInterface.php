<?php namespace App\Src\Information\Domain\Interfaces;


use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Information\Domain\Model\InformationSpecification;

interface InformationInterface extends Repository
{

    /**
     * @param InformationSpecification $spec
     * @param int                   $per_page
     * @return mixed
     */
    public function search(InformationSpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);
}