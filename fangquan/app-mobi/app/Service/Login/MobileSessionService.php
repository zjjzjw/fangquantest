<?php

namespace App\Mobi\Service\Login;


use App\Service\FqUser\CheckTokenService;
use App\Service\Match\MatchService;
use App\Service\Smser\SmserService;
use App\Src\Exception\LoginException;
use App\Src\FqUser\Domain\Model\CheckThirdPartyEntity;
use App\Src\FqUser\Domain\Model\FqUserAccountStatus;
use App\Src\FqUser\Domain\Model\FqUserAccountType;
use App\Src\FqUser\Domain\Model\FqUserEntity;
use App\Src\FqUser\Domain\Model\FqUserLoginType;
use App\Src\FqUser\Domain\Model\FqUserPlatformType;
use App\Src\FqUser\Domain\Model\FqUserRegisterType;
use App\Src\FqUser\Domain\Model\FqUserRoleType;
use App\Src\FqUser\Domain\Model\FqUserStatus;
use App\Src\FqUser\Domain\Model\LoginLogEntity;
use App\Src\FqUser\Domain\Model\MobileLoginEntity;
use App\Src\FqUser\Domain\Model\MobileRegStatus;
use App\Src\FqUser\Domain\Model\MobileSessionEntity;
use App\Src\FqUser\Domain\Model\ThirdPartyBindEntity;
use App\Src\FqUser\Domain\Model\ValidMobileEntity;
use App\Src\FqUser\Domain\Model\VerifyCodeType;
use App\Src\FqUser\Infra\Repository\FqUserRepository;
use App\Src\FqUser\Infra\Repository\LoginLogRepository;
use App\Src\FqUser\Infra\Repository\MobileSessionRepository;
use App\Src\FqUser\Infra\Repository\ThirdPartyBindRepository;
use App\Src\FqUser\Infra\Repository\ValidMobileRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

class MobileSessionService
{
    public function login($mobile_login_entity)
    {
        $account = $mobile_login_entity->account;
        $password = $mobile_login_entity->password;
        $reg_id = $mobile_login_entity->reg_id;
        $ip = $mobile_login_entity->ip;
        $account_type = $this->getAccountType($account);
        $fq_user_repository = new FqUserRepository();
        $fq_user_model = $fq_user_repository->getFqUserModel($account, $account_type, $password);
        if (!isset($fq_user_model)) {
            throw new LoginException('', LoginException::ERROR_LOGIN_FAILED);
        }

        if ($fq_user_model->status == FqUserStatus::NO_ACTIVE) {
            throw new LoginException('', LoginException::ERROR_LOGIN_FAILED_ACCOUNT_NOT_ACTIVE);
        } elseif ($fq_user_model->status == FqUserStatus::DISABLE) {
            throw new LoginException('', LoginException::ERROR_ACCOUNT_DISABLE);
        } else {
            $data = $this->saveLoginRecord($fq_user_model->id, $reg_id, $ip);
        }
        return $data;
    }

    /**
     * 生成登录信息
     * @param $user_id
     * @param $reg_id
     * @param $client_ip
     * @return array
     */
    public function saveLoginRecord($user_id, $reg_id, $client_ip)
    {
        //生成登录信息
        $token = $this->generateAccessToken();
        $mobile_session_repository = new MobileSessionRepository();
        /** @var MobileSessionEntity $mobile_session_entity */
        $mobile_session_entity = $mobile_session_repository->getMobileSessionByUserId($user_id);
        if (empty($mobile_session_entity)) {
            $mobile_session_entity = new MobileSessionEntity();
            $mobile_session_entity->user_id = $user_id;
        }
        $mobile_session_entity->token = $token;
        $mobile_session_entity->reg_id = $reg_id ?? '';
        $mobile_session_entity->type = FqUserPlatformType::TYPE_IOS;
        $mobile_session_entity->enable_notify = MobileRegStatus::YES_REG;
        $mobile_session_repository->save($mobile_session_entity);
        if (!empty($reg_id)) {
            $mobile_session_repository->deleteRedId($reg_id, $user_id);
        }
        //生产日志信息
        $login_log_repository = new LoginLogRepository();
        /** @var LoginLogEntity $mobile_log_entity */
        $mobile_log_entity = $login_log_repository->getLoginLogByUserId($user_id);
        if (empty($mobile_log_entity)) {
            $mobile_log_entity = new LoginLogEntity();
            $mobile_log_entity->user_id = $user_id;
        }
        $mobile_log_entity->type = FqUserLoginType::TYPE_APP;
        $mobile_log_entity->ip = $client_ip;
        $login_log_repository->save($mobile_log_entity);
        return $data = [
            "success" => true,
            "code"    => 200,
            "user_id" => $user_id,
            "token"   => $token,
        ];
    }

    /**
     * 获取账号类型
     * @param $account
     * @return int
     */
    public function getAccountType($account)
    {
        if (MatchService::isEmail($account)) {
            return FqUserAccountStatus::TYPE_EMAIL;
        } elseif (MatchService::isMobile($account)) {
            return FqUserAccountStatus::TYPE_MOBILE;
        } else {
            return FqUserAccountStatus::TYPE_ADMIN;
        }
    }

    /**
     * 生成访问口令
     *
     * @return string
     */
    public function generateAccessToken()
    {
        return md5(uniqid("fq_mobile", true));
    }

    /**
     * 随机验证码
     * @return string
     */
    public function randCode()
    {
        return (String)rand(100000, 999999);
    }

    /**
     * 防止频繁发送
     * @param $phone
     * @return bool
     */
    public function isFrequently($phone)
    {
        $valid_mobile_repository = new ValidMobileRepository();
        $valid_mobile = $valid_mobile_repository->getValidMobileByPhone($phone);
        // 一分钟只能发送一次
        return $valid_mobile && Carbon::parse($valid_mobile->updated_at)->addMinutes(SmserService::VERIFY_CODE_FREQUENTLY_MINUTES) > Carbon::now();
    }

    /**
     * 验证验证码是否正确
     * @param $phone
     * @param $verifyCode
     * @return int
     */
    public function validVerifyCode($phone, $verifyCode)
    {
        $valid_mobile_repository = new ValidMobileRepository();
        $valid_mobile = $valid_mobile_repository->getValidMobileByPhone($phone);
        if ($valid_mobile && $valid_mobile->verifycode == $verifyCode) {
            if ($this->isVerifyCodeTimeout($valid_mobile)) {
                return LoginException::ERROR_SMS_VERIFY_CODE_TIMEOUT;
            } else {
                return 200;
            }
        } else {
            return LoginException::ERROR_SMS_VERIFY_CODE_ERROR;
        }
    }

    /**
     * 验证码是否已过期
     *
     * @param $model
     * @return bool
     */
    public function isVerifyCodeTimeout($model)
    {
        return Carbon::parse($model->expire) < Carbon::now();
    }

    /**
     * 获取验证码
     * @param $verify_code_entity
     * @throws LoginException
     */
    public function getVerifyCode($verify_code_entity)
    {
        $phone = $verify_code_entity->phone;
        $type = $verify_code_entity->type;
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $fq_user_repository = new FqUserRepository();
        if (!MatchService::isMobile($phone)) {
            throw new LoginException('', LoginException::ERROR_MOBILE_PATTERN_INVALID);
        } elseif ($fq_user_repository->getFqUserByPhone($phone) && (($type == VerifyCodeType::REGISTER || $type == VerifyCodeType::BIND_PHONE))) {
            throw new LoginException('', LoginException::ERROR_SMS_REGISTER_MOBILE_IS_EXIST);
        } elseif ($type == VerifyCodeType::RETRIEVE_PWD && !$fq_user_repository->getFqUserByPhone($phone)) {
            throw new LoginException('', LoginException::ERROR_SMS_SEND_RETRIEVE_PWD_PHONE_NOT_EXIST);
        }
        $valid_mobile_repository = new ValidMobileRepository();
        switch ($type) {
            case VerifyCodeType::REGISTER:
            case VerifyCodeType::RETRIEVE_PWD:
            case VerifyCodeType::BIND_PHONE:
                if ($this->isFrequently($phone)) {
                    throw new LoginException('', LoginException::ERROR_SMS_SEND_TOO_FREQUENTLY);
                }
                /** @var ValidMobileEntity $valid_mobile_entity */
                $valid_mobile_entity = $valid_mobile_repository->getValidMobileByPhone($phone);
                if (empty($valid_mobile_entity)) {
                    $valid_mobile_entity = new ValidMobileEntity();
                    $valid_mobile_entity->mobile = $phone;
                }
                $valid_mobile_entity->verifycode = $this->randCode();
                $valid_mobile_entity->expire = Carbon::parse($now)->addMinutes(SmserService::VERIFY_CODE_TIMEOUT_MINUTES);
                $valid_mobile_repository->save($valid_mobile_entity);
                SmserService::sendMessage($phone, $valid_mobile_entity->verifycode);
                break;
        }
    }

    /**
     * 手机号注册
     * @param $mobile_register_entity
     * @return array
     * @throws LoginException
     */
    public function mobileRegister($mobile_register_entity)
    {
        $phone = $mobile_register_entity->phone;
        $verifyCode = $mobile_register_entity->verifycode;
        $password = $mobile_register_entity->password;
        $reg_id = $mobile_register_entity->reg_id;
        $device_type = '';//这个暂时不填,后面统一加上去
        $fq_user_repository = new FqUserRepository();
        if (!MatchService::isMobile($phone)) {
            throw new LoginException('', LoginException::ERROR_MOBILE_PATTERN_INVALID);
        } elseif ($fq_user_repository->getFqUserByPhone($phone)) {
            throw new LoginException('', LoginException::ERROR_MOBILE_IS_EXIST);
        }

        //手机验证码是否正确
        $code = $this->validVerifyCode($phone, $verifyCode);
        if ($code == 200) {
            $fq_user_entity = new FqUserEntity();
            $fq_user_entity->nickname = 'fq' . time();
            $fq_user_entity->salt = $this->randCode();
            $fq_user_entity->password = md5($password . $fq_user_entity->salt);
            $now = Carbon::now()->format('Y-m-d H:i:s');
            $fq_user_entity->reg_time = $now;
            $fq_user_entity->role_type = FqUserRoleType::UNKNOWN;
            $fq_user_entity->role_id = 0;
            $fq_user_entity->email = "";
            $fq_user_entity->account = "";
            $fq_user_entity->avatar = 0;
            $fq_user_entity->project_area = "";
            $fq_user_entity->project_category = "";
            $fq_user_entity->admin_id = 0;
            $fq_user_entity->company_name = "";
            $fq_user_entity->mobile = $phone;
            $fq_user_entity->status = FqUserStatus::NORMAL_USE;// 正常使用
            $fq_user_entity->account_type = FqUserAccountType::TYPE_FREE;//免费账号
            $fq_user_entity->register_type_id = FqUserRegisterType::PHONE;
            if (strcasecmp($device_type, "android") == 0) {
                $fq_user_entity->platform_id = FqUserPlatformType::TYPE_ANDROID;
            } else if (strcasecmp($device_type, "ios") == 0) {
                $fq_user_entity->platform_id = FqUserPlatformType::TYPE_IOS;
            } else {
                $fq_user_entity->platform_id = 0;//未知类型
            }
            $fq_user_repository->save($fq_user_entity);
            //App注册后，需要自动进入登录状态
            $mobile_login_entity = new MobileLoginEntity();
            $mobile_login_entity->account = $phone;
            $mobile_login_entity->password = $password;
            $mobile_login_entity->ip = Request::ip();
            $mobile_login_entity->reg_id = $reg_id;
            $mobile_login = $this->login($mobile_login_entity);
            return $mobile_login;
        } else {
            throw new LoginException('', $code);
        }
    }


    /**
     * 第三方注册
     * @param $third_party_register_entity
     * @return array
     */
    public function thirdPartyRegister($third_party_register_entity)
    {
        $third_type = $third_party_register_entity->third_type;
        $open_id = $third_party_register_entity->open_id;
        $nickname = $third_party_register_entity->nickname;
        $avatar = $third_party_register_entity->avatar;
        $reg_id = $third_party_register_entity->reg_id;
        $device_type = $third_party_register_entity->device_type;

        $check_third_party_entity = new CheckThirdPartyEntity();
        $check_third_party_entity->open_id = $open_id;
        $check_third_party_entity->third_type = $third_type;
        $check_third_party_entity->reg_id = $reg_id;
        $data = $this->checkThirdPartyRegister($check_third_party_entity);
        if ($data['code'] == 200) {
            // 如果已经注册过，则直接返回用户信息
            return $data;
        } else {
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
            $fq_user_entity->reg_time = $now;
            $fq_user_entity->role_type = FqUserRoleType::UNKNOWN;
            $fq_user_entity->role_id = 0;
            $fq_user_entity->status = FqUserStatus::NORMAL_USE;// 正常使用
            $fq_user_entity->account_type = FqUserAccountType::TYPE_FREE;//免费账号
            if (strcasecmp($device_type, "android") == 0) {
                $fq_user_entity->platform_id = FqUserPlatformType::TYPE_ANDROID;
            } else if (strcasecmp($device_type, "ios") == 0) {
                $fq_user_entity->platform_id = FqUserPlatformType::TYPE_IOS;
            } else {
                $fq_user_entity->platform_id = 0;//未知类型
            }
            $fq_user_entity->register_type_id = FqUserRegisterType::WECHAT;
            $fq_user_repository->save($fq_user_entity);
            //App注册后自动登录
            $data = $this->saveLoginRecord($fq_user_entity->id, $reg_id, Request::ip());
            //第三方绑定表插入数据
            $third_party_bind_repository = new ThirdPartyBindRepository();
            $third_party_bind_entity = new ThirdPartyBindEntity();
            $third_party_bind_entity->open_id = $open_id;
            $third_party_bind_entity->user_id = $fq_user_entity->id;
            $third_party_bind_entity->third_type = FqUserRegisterType::WECHAT;
            $third_party_bind_repository->save($third_party_bind_entity);
            return $data;

        }
    }

    /**
     * 检测第三方是否注册
     * @param $check_third_party_entity
     * @return array
     */
    public function checkThirdPartyRegister($check_third_party_entity)
    {
        $third_party_bind_repository = new ThirdPartyBindRepository();
        $data = [
            "code"    => LoginException::ERROR_THIRD_PARTY_NOT_REGISTER,
            'success' => false,

        ];
        $third_party_bind = $third_party_bind_repository->getThirdPartyBindByThirdTypeAndOpenId($check_third_party_entity->third_type, $check_third_party_entity->open_id);
        if (!empty($third_party_bind)) {
            //如果注册过直接返回登录信息
            $data = $this->saveLoginRecord($third_party_bind->user_id, $check_third_party_entity->reg_id, Request::ip());
        }
        return $data;
    }

    /**
     * 更改配置
     * @param $config_entity
     * @return array
     */
    public function updateNotifyConfig($config_entity)
    {
        $mobile_session_repository = new MobileSessionRepository();
        $mobile_session_entity = $mobile_session_repository->getMobileSessionByUserId($config_entity->user_id);
        if (isset($mobile_session_entity)) {
            $mobile_session_entity->enable_notify = $config_entity->enable_notify;
            $mobile_session_repository->save($mobile_session_entity);
            return $data = [
                "success" => true,
            ];
        } else {
            return $data = [
                "success" => false,
            ];
        }
    }

    /**
     * 通过手机号找回密码
     * @param $retrieve_password_by_phone_entity
     * @return array
     * @throws LoginException
     */
    public function retrievePasswordByPhone($retrieve_password_by_phone_entity)
    {
        $phone = $retrieve_password_by_phone_entity->phone;
        if (!MatchService::isMobile($phone)) {
            throw new LoginException('', LoginException::ERROR_MOBILE_PATTERN_INVALID);
        }
        $verifyCode = $retrieve_password_by_phone_entity->verifycode;
        $password = $retrieve_password_by_phone_entity->password;
        return $this->resetPasswordByPhone($phone, $verifyCode, $password);
    }

    /**
     * @param $phone
     * @param $verifyCode
     * @param $password
     * @return array
     * @throws LoginException
     */
    public function resetPasswordByPhone($phone, $verifyCode, $password)
    {
        $data = [];
        $fq_user_repository = new FqUserRepository();
        if ($fq_user_repository->getFqUserByPhone($phone)) {
            // 手机验证码是否正确
            $code = $this->validVerifyCode($phone, $verifyCode);
            if ($code == 200) {
                $fq_user_entity = $fq_user_repository->getFqUserByMobile($phone);
                $fq_user_entity->password = md5($password . $fq_user_repository->findSalt($phone, FqUserAccountStatus::TYPE_MOBILE));
                $fq_user_repository->save($fq_user_entity);
                $data = [
                    "code"    => 200,
                    'success' => true,
                ];
                return $data;
            } else {
                throw new LoginException('', $code);
            }
        } else {
            throw new LoginException('', LoginException::ERROR_SMS_SEND_RETRIEVE_PWD_PHONE_NOT_EXIST);
        }
    }

    /**
     * 绑定手机号
     * @param $bind_phone_entity
     * @return array
     * @throws LoginException
     */
    public function bindPhone($bind_phone_entity)
    {
        $fq_user_repository = new FqUserRepository();
        if ($fq_user_repository->getFqUserByPhone($bind_phone_entity->phone)) {
            throw new LoginException('', LoginException::ERROR_SMS_REGISTER_MOBILE_IS_EXIST);
        } else {
            $errorCode = $this->validVerifyCode($bind_phone_entity->phone, $bind_phone_entity->verifycode);
            if ($errorCode == 200) {
                $user_id = CheckTokenService::getUserId();
                $fq_user_entity = $fq_user_repository->fetch($user_id);
                $fq_user_entity->mobile = $bind_phone_entity->phone;
                $fq_user_repository->save($fq_user_entity);
                return ['success' => true];
            } else {
                throw new LoginException('', $errorCode);
            }
        }
    }

}

