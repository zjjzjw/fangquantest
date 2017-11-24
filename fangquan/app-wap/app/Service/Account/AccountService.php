<?php

namespace App\Wap\Service\Account;


use App\Service\Match\MatchService;
use App\Src\FqUser\Domain\Model\CheckThirdPartyEntity;
use App\Src\FqUser\Domain\Model\FqUserAccountType;
use App\Src\FqUser\Domain\Model\FqUserEntity;
use App\Src\FqUser\Domain\Model\FqUserPlatformType;
use App\Src\FqUser\Domain\Model\FqUserRegisterType;
use App\Src\FqUser\Domain\Model\FqUserRoleType;
use App\Src\FqUser\Domain\Model\FqUserStatus;
use App\Src\FqUser\Domain\Model\ThirdPartyBindEntity;
use App\Src\FqUser\Infra\Repository\FqUserRepository;
use App\Src\FqUser\Infra\Repository\ThirdPartyBindRepository;
use Carbon\Carbon;

class AccountService
{
    /**
     * 第三方注册
     * @param $open_id
     * @param $nickname
     * @param $avatar
     * @return int
     */
    public function thirdPartyRegister($open_id, $nickname, $avatar)
    {
        $check_third_party_entity = new CheckThirdPartyEntity();
        $check_third_party_entity->open_id = $open_id;
        $check_third_party_entity->third_type = FqUserRegisterType::WECHAT;
        $fq_user_repository = new FqUserRepository();
        $fq_user_entity = new FqUserEntity();
        if (!empty($nickname) && MatchService::isValidNickname($nickname)) {
            $fq_user_entity->nickname = $nickname;
        } else {
            $fq_user_entity->nickname = 'fq' . time();
        }
        $fq_user_entity->avatar = $avatar;
        $fq_user_entity->mobile = "";
        $fq_user_entity->email = "";
        $fq_user_entity->account = "";
        $fq_user_entity->project_area = "";
        $fq_user_entity->project_category = "";
        $fq_user_entity->admin_id = 0;
        $fq_user_entity->company_name = "";
        $fq_user_entity->password = "";
        $fq_user_entity->salt = "";
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $expire = Carbon::now()->addMonth()->toDateTimeString();
        $fq_user_entity->expire = $expire;
        $fq_user_entity->reg_time = $now;

        $fq_user_entity->role_type = FqUserRoleType::UNKNOWN;
        $fq_user_entity->role_id = 0;
        $fq_user_entity->status = FqUserStatus::NORMAL_USE;// 正常使用
        $fq_user_entity->account_type = FqUserAccountType::TYPE_FREE;//免费账号
        $fq_user_entity->platform_id = FqUserPlatformType::TYPE_WECHAT_PUBLIC;//微信公众号
        $fq_user_entity->register_type_id = FqUserRegisterType::WECHAT_PUBLIC;//微信公众号
        $fq_user_repository->save($fq_user_entity);
        //第三方绑定表插入数据
        $third_party_bind_repository = new ThirdPartyBindRepository();
        $third_party_bind_entity = new ThirdPartyBindEntity();
        $third_party_bind_entity->open_id = $open_id;
        $third_party_bind_entity->user_id = $fq_user_entity->id;
        $third_party_bind_entity->third_type = FqUserRegisterType::WECHAT_PUBLIC;
        $third_party_bind_repository->save($third_party_bind_entity);
        return $fq_user_entity->id;
    }


}

