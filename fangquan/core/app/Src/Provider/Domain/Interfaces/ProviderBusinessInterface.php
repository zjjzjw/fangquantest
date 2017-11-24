<?php namespace App\Src\Provider\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Provider\Domain\Model\ProviderBusinessSpecification;

interface ProviderBusinessInterface extends Repository
{
    /**
     * @param ProviderBusinessSpecification $spec
     * @param int                           $per_page
     * @return mixed
     */
    public function search(ProviderBusinessSpecification $spec, $per_page = 10);

}