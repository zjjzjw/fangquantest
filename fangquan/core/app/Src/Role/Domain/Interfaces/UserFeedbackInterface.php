<?php namespace App\Src\Role\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Role\Domain\Model\UserFeedbackSpecification;

interface UserFeedbackInterface extends Repository
{

    /**
     * @param UserFeedbackSpecification $spec
     * @param int                       $per_page
     * @return mixed
     */
    public function search(UserFeedbackSpecification $spec, $per_page);

}