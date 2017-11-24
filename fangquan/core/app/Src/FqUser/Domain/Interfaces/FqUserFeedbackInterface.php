<?php namespace App\Src\FqUser\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\FqUser\Domain\Model\FqUserFeedbackSpecification;
use App\Src\FqUser\Domain\Model\FqUserSpecification;

interface FqUserFeedbackInterface extends Repository
{

    /**
     * @param int $id
     * @return mixed|void
     */
    public function delete($id);

    public function search(FqUserFeedbackSpecification $spec, $per_page = 20);
}