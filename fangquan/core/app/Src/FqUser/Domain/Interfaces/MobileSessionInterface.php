<?php namespace App\Src\FqUser\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\FqUser\Domain\Model\MobileSessionSpecification;

interface MobileSessionInterface extends Repository
{
    /**
     * @param MobileSessionSpecification          $spec
     * @param                                     $per_page
     * @return mixed
     */
    public function search(MobileSessionSpecification $spec, $per_page);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);


    /**
     * @param $user_id
     * @return mixed
     */
    public function getMobileSessionByUserId($user_id);

}