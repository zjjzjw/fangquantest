<?php namespace App\Src\FqUser\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\FqUser\Domain\Model\ValidMobileSpecification;

interface ValidMobileInterface extends Repository
{
    /**
     * @param ValidMobileSpecification            $spec
     * @param                                     $per_page
     * @return mixed
     */
    public function search(ValidMobileSpecification $spec, $per_page);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

}