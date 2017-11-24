<?php namespace App\Src\FqUser\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\FqUser\Domain\Model\ThirdPartyBindSpecification;

interface ThirdPartyBindInterface extends Repository
{
    /**
     * @param ThirdPartyBindSpecification         $spec
     * @param                                     $per_page
     * @return mixed
     */
    public function search(ThirdPartyBindSpecification $spec, $per_page);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param $id
     * @return mixed
     */
    public function getFqUserById($id);

}