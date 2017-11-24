<?php

namespace App\Hulk\Service\User;


use App\Src\Content\Domain\Model\UserInfoEntity;
use App\Src\Content\Infra\Repository\UserInfoRepository;
use App\Src\FqUser\Domain\Model\FqUserEntity;
use App\Src\FqUser\Infra\Repository\FqUserRepository;
use App\Src\Role\Domain\Model\UserEntity;
use App\Src\Role\Domain\Model\UserType;
use App\Src\Role\Infra\Repository\UserRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;

class UserHulkService
{

    public function getUserInfo($openid, $data)
    {
        $user_repository = new UserRepository();
        $user_entity = $user_repository->getUserByOpenId($openid);
        if (!isset($user_entity)) {
            $user_entity = new UserEntity();
            $user_entity->employee_id = 0;
            $user_entity->company_id = 0;
            $user_entity->type = UserType::CUSTOMER;
            $user_entity->email = '';
            $user_entity->status = 0;
            $user_entity->created_user_id = 0;
            $user_entity->account = $data['nickName'] ?? '';
            $user_entity->company_name = '';
            $user_entity->position = '';
            $user_entity->name = $data['nickName'] ?? '';
            $user_entity->phone = '';
            $user_entity->avatar = $data['avatarUrl'] ?? '';
            $user_entity->role_ids = [];
            $user_entity->third_party_bind = [$openid];
            $user_repository->save($user_entity);
        } else {
            $user_entity->account = $data['nickName'] ?? '';
            $user_entity->name = $data['nickName'] ?? '';
            $user_entity->avatar = $data['avatarUrl'] ?? '';
            $user_repository->save($user_entity);
        }
        $user_entity = $user_repository->fetch($user_entity->id);
        $data = $user_entity->toArray();
        return $data;
    }

    public function getFqUserInfo($id)
    {
        $data = [];
        $fq_user_repository = new FqUserRepository();
        $user_info_repository = new UserInfoRepository();
        /** @var FqUserEntity $fq_user_entity */
        $fq_user_entity = $fq_user_repository->fetch($id);
        $resource_repository = new ResourceRepository();
        if (isset($fq_user_entity)){
            $data = $fq_user_entity->toArray();
            //得到缩略图
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($fq_user_entity->avatar);
            if (isset($resource_entity)) {
                $data['thumbnail_url'] = $resource_entity->url;
                $thumbnail_images = [];
                $thumbnail_image = [];
                $thumbnail_image['image_id'] = $fq_user_entity->avatar;
                $thumbnail_image['url'] = $resource_entity->url;
                $thumbnail_images[] = $thumbnail_image;
                $data['thumbnail_images'] = $thumbnail_images;
                $data['image_url'] = $resource_entity->url;
            }
            /** @var UserInfoEntity $user_info_entity */
            $user_info_entity = $user_info_repository->getUserInfoByUserId($fq_user_entity->id);
            $data['position'] = $user_info_entity->position ?? '';
        }
        return $data;
    }
}

