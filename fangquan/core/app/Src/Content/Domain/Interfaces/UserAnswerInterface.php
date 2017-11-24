<?php namespace App\Src\Content\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Content\Domain\Model\UserAnswerSpecification;

interface UserAnswerInterface extends Repository
{

    /**
     * @param int|array $ids
     */
    public function delete($ids);
}