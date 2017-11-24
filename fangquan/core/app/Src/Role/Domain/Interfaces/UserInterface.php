<?php namespace App\Src\Role\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Role\Domain\Model\UserEntity;
use App\Src\Role\Domain\Model\UserSpecification;

interface UserInterface extends Repository
{

    /**
     * @param UserSpecification $spec
     * @param int               $per_page
     * @return mixed
     */
    public function search(UserSpecification $spec, $per_page);

    /**
     * @param  array $ids
     * @return array|\Illuminate\Support\Collection
     */
    public function getUserByIds($ids);

    /**
     * @var string|array $phone
     * @return array|\Illuminate\Support\Collection
     */
    public function getUserByPhone($phone);

    /**
     * @param int|array $ids
     */
    public function delete($ids);

    /**
     * @param $employee_id
     * @return mixed
     */
    public function getUserByEmployee($employee_id);

    /**
     * 修改密码
     * @param $user_entity
     */
    public function updatePassword($user_entity);

    /**
     * @param string $account
     * @return array|\Illuminate\Support\Collection
     */
    public function getUserByAccount($account);

    /**
     * @return array|\Illuminate\Support\Collection
     */
    public function all();

    /**
     * @param int     $id
     * @param boolean $with_thread
     * @return UserEntity|null
     */
    public function getUserById($id);

    /**
     * @param  int $id
     */
    public function updateUploadNum($id);
}