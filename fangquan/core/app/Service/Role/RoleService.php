<?php

namespace App\Service\Role;

use App\Src\Role\Domain\Model\PermissionEntity;
use App\Src\Role\Domain\Model\RoleEntity;
use App\Src\Role\Domain\Model\RoleSpecification;
use App\Src\Role\Infra\Repository\PermissionRepository;
use App\Src\Role\Infra\Repository\RoleRepository;
use App\Src\Role\Infra\Repository\UserRoleRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleService
{
    /**
     * @param RoleSpecification $spec
     * @param int               $per_page
     * @return array
     */
    public function getRoleList(RoleSpecification $spec, $per_page)
    {
        $data = [];
        $role_repository = new RoleRepository();
        $paginate = $role_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var int                  $key
         * @var RoleEntity           $role_entity
         * @var LengthAwarePaginator $paginate
         */
        $permission_repository = new PermissionRepository();
        $permission_entities = $permission_repository->all();

        $user_role_repository = new UserRoleRepository();
        foreach ($paginate as $key => $role_entity) {
            $item = $role_entity->toArray();
            $item_permissions = $permission_entities->filter(function ($value) use ($item) {
                return in_array($value->id, $item['permissions'] ?? []);
            });
            $names = [];
            $user_names = [];

            $user_role_entities = $user_role_repository->getUserRoleByRoleId($item['id']);
            if ($user_role_entities->isEmpty()) {
                foreach ($user_role_entities as $user_role_entity) {
                    $user_names[] = $user_role_entity->user->name;
                }
                $item['user_names'] = implode(',', $user_names);
            }

            foreach ($item_permissions as $item_permission) {
                $names[] = $item_permission->name;
            }
            $item['permission_names'] = implode(',', $names);
            $paginate[$key] = $item;
            $items[] = $item;
        }

        $data['paginate'] = $paginate;
        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();

        return $data;
    }

    public function getRoleInfo($id)
    {
        $data = [];
        $role_repository = new RoleRepository();
        $role_entity = $role_repository->fetch($id);
        if (isset($role_entity)) {
            $data = $role_entity->toArray();
        }
        return $data;
    }

    public function getPermissions()
    {
        $items = [];
        $permission_repository = new PermissionRepository();
        $permission_entities = $permission_repository->all();
        /** @var PermissionEntity $permission_entity */
        foreach ($permission_entities as $permission_entity) {
            $items[$permission_entity->id] = $permission_entity->toArray();
        }

        return $items;
    }

    /**
     * @param $company_id
     * @return array
     */
    public function getRoleByCompanyId($company_id)
    {
        $roles = [];
        $role_repository = new RoleRepository();
        $roles_entities = $role_repository->getRoleByCompanyId($company_id);
        foreach ($roles_entities as $roles_entity) {
            $roles[] = $roles_entity->toArray();
        }
        return $roles;
    }

    public function getUserRoleList()
    {
        $roles = [];
        $role_repository = new RoleRepository();
        $roles_entities = $role_repository->all();
        foreach ($roles_entities as $roles_entity) {
            $roles[] = $roles_entity->toArray();
        }
        return $roles;
    }
}

