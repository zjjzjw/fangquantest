<?php namespace App\Src\Provider\Domain\Interfaces;


use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Provider\Domain\Model\ProviderProductProgrammeSpecification;

interface ProviderProductProgrammeInterface extends Repository
{
    /**
     * @param ProviderProductProgrammeSpecification $spec
     * @param int                                   $per_page
     * @return mixed
     */
    public function search(ProviderProductProgrammeSpecification $spec, $per_page = 10);

    /**
     * @param int|array $id
     */
    public function delete($id);
}