<?php

namespace App\Service\Role;

use App\Src\Role\Domain\Model\DataType;
use App\Src\Role\Domain\Model\DepartEntity;
use App\Src\Role\Domain\Model\RoleEntity;
use App\Src\Role\Domain\Model\UserDataEntity;
use App\Src\Role\Domain\Model\UserEntity;
use App\Src\Role\Domain\Model\UserSpecification;
use App\Src\Role\Infra\Eloquent\UserDepartModel;
use App\Src\Role\Infra\Eloquent\UserModel;
use App\Src\Role\Infra\Repository\DepartRepository;
use App\Src\Role\Infra\Repository\UserDataRepository;
use App\Src\Role\Infra\Repository\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{

    public function getUserList(UserSpecification $spec, $per_page = 20)
    {
        $data = [];
        $user_repository = new UserRepository();
        $paginate = $user_repository->search($spec, $per_page);

        $items = [];
        $user_depart_model = new UserDepartModel();
        $depart_repository = new DepartRepository();

        /**
         * @var int                  $key
         * @var UserEntity           $user_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $user_entity) {
            $item = $user_entity->toArray();
            /** @var UserDepartModel $user_depart_entity */
            $user_depart_entity = $user_depart_model->where(['user_id' => $item['id']])->first();
            /** @var DepartEntity $depart_entity */
            $depart_entity = $depart_repository->fetch($user_depart_entity->depart_id ?? 0);
            $item['user_depart_name'] = $depart_entity->name ?? '';
            $items[] = $item;
        }

        $data['paginate'] = $paginate;
        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();
        return $data;
    }

    /**
     * 获取user
     * @param $id
     * @return array
     */
    public function getUserInfoById($id)
    {
        $data = [];
        $user_repository = new UserRepository();
        /** @var UserEntity $user_entity */
        $user_entity = $user_repository->fetch($id);
        if (isset($user_entity)) {
            $data = $user_entity->toArray();
            if (!empty($user_entity->roles)) {
                $role = current($user_entity->roles);
                $data['role_name'] = $role['name']; //角色就是职位
            }
            if (!empty($user_entity->departs)) {
                $depart = current($user_entity->departs);
                $data['depart_name'] = $depart['name']; //部门
            }
            //$data['start_time'] = $user_entity->start_time->format('Y-m-d');
            //$data['end_time'] = $user_entity->end_time->format('Y-m-d');

            //得到头像信息
            $user_images = [];
            if (!empty($user_entity->image_id)) {
                $image = [];
                $image['image_id'] = $user_entity->image_id;
                $resource_repository = new ResourceRepository();
                $image_entities = $resource_repository->getResourceUrlByIds($user_entity->image_id);
                $image['url'] = $image_entities[$user_entity->image_id]->url ?? '';
                $user_images[] = $image;
            }
            $data['user_images'] = $user_images;
        }
        return $data;
    }


    public function getUserByEmployee($employee_id)
    {
        return UserModel::where('employee_id', $employee_id)->first();
    }


}