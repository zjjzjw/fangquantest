<?php

namespace App\Mobi\Service\FqUser;


use App\Service\Match\MatchService;
use App\Src\Exception\LoginException;
use App\Src\FqUser\Domain\Model\FqUserEntity;
use App\Src\FqUser\Infra\Repository\FqUserRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;

class UserInfoService
{
    /**
     * 获取个人资料
     * @param $user_id
     * @return array
     */
    public function getUserInfoByUserId($user_id)
    {
        $item = [];
        $fq_user_repository = new FqUserRepository();
        $resource_repository = new ResourceRepository();
        /** @var FqUserEntity $fq_user_entity */
        $fq_user_entity = $fq_user_repository->fetch($user_id);
        if (isset($fq_user_entity)) {
            //得到用户图像
            /** @var ResourceEntity $resource_entity */
            $resource_entity = $resource_repository->fetch($fq_user_entity->avatar);
            $item['nickname'] = $fq_user_entity->nickname;
            $item['avatar'] = $resource_entity->url ?? '';
            $item['mobile'] = $fq_user_entity->mobile;
            $item['role_type'] = $fq_user_entity->role_type;
        }
        return $item;
    }

    /**
     * 修改个人资料
     * @param $user_id
     * @param $param
     * @return array
     * @throws LoginException
     */
    public function editUserInfoByUserId($user_id, $param)
    {
        $fq_user_repository = new FqUserRepository();
        /** @var FqUserEntity $fq_user_entity */
        $fq_user_entity = $fq_user_repository->fetch($user_id);
        if (isset($param['nickname']) && !MatchService::isValidNickname($param['nickname'])) {
            throw new LoginException('', LoginException::ERROR_NICKNAME_INVALID);
        }
        if (isset($fq_user_entity)) {
            if (isset($param['nickname'])) {
                $fq_user_entity->nickname = $param['nickname'];
            }
            if (isset($param['avatar'])) {
                $fq_user_entity->avatar = $param['avatar'];
            }
            $fq_user_repository->save($fq_user_entity);
            return ['success' => true];
        }
        return ['success' => false];
    }
}

