<?php namespace App\Src\Msg\Domain\Interfaces;


use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Msg\Domain\Model\UserMsgSpecification;

interface UserMsgInterface extends Repository
{

    /**
     * 得到唯独消息数量
     * @param int       $user_id
     * @param int|array $msg_type
     * @param int|array $status
     * @return mixed
     */
    public function getMsgCount($user_id, $msg_type, $status);

    /**
     * @param UserMsgSpecification $spec
     * @param int                          $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(UserMsgSpecification $spec, $per_page = 10);
}