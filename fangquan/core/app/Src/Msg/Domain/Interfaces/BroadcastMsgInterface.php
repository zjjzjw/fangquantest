<?php namespace App\Src\Msg\Domain\Interfaces;


use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Msg\Domain\Model\BroadcastMsgSpecification;

interface BroadcastMsgInterface extends Repository
{

    /**
     * @param BroadcastMsgSpecification $spec
     * @param int                       $per_page
     * @return mixed
     */
    public function search(BroadcastMsgSpecification $spec, $per_page = 10);
}