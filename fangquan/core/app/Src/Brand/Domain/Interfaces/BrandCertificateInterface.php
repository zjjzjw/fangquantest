<?php namespace App\Src\Brand\Domain\Interfaces;


use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Brand\Domain\Model\BrandCertificateSpecification;

interface BrandCertificateInterface extends Repository
{

    /**
     * @param BrandCertificateSpecification $spec
     * @param int                           $per_page
     * @return mixed
     */
    public function search(BrandCertificateSpecification $spec, $per_page = 10);

    /**
     * @param int|array $ids
     */
    public function delete($ids);
}