<?php

namespace App\Web\Service\Account;


use App\Service\Developer\DeveloperService;
use App\Service\Match\MatchService;
use App\Service\Msg\UserMsgService;
use App\Service\Provider\ProviderService;
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
use App\Src\FqUser\Domain\Model\ThirdPartyBindEntity;
use App\Src\FqUser\Domain\Model\ValidMobileEntity;
use App\Src\FqUser\Domain\Model\VerifyCodeType;
use App\Src\FqUser\Infra\Repository\FqUserRepository;
use App\Src\FqUser\Infra\Repository\LoginLogRepository;
use App\Src\FqUser\Infra\Repository\MobileSessionRepository;
use App\Src\FqUser\Infra\Repository\ThirdPartyBindRepository;
use App\Src\FqUser\Infra\Repository\ValidMobileRepository;
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AccountService
{
    public function login($mobile_login_entity)
    {
        $account = $mobile_login_entity->account;
        $password = $mobile_login_entity->password;
        $ip = $mobile_login_entity->ip;
        $account_type = $this->getAccountType($account);
        $fq_user_repository = new FqUserRepository();
        $fq_user_model = $fq_user_repository->getFqUserModel($account, $account_type, $password, FqUserPlatformType::TYPE_PC);
        if (!isset($fq_user_model)) {
            throw new LoginException('', LoginException::ERROR_LOGIN_FAILED);
        }

        if ($fq_user_model->status == FqUserStatus::NO_ACTIVE) {
            throw new LoginException('', LoginException::ERROR_LOGIN_FAILED_ACCOUNT_NOT_ACTIVE);
        } elseif ($fq_user_model->status == FqUserStatus::DISABLE) {
            throw new LoginException('', LoginException::ERROR_ACCOUNT_DISABLE);
        } else {
            $data = $this->saveLoginRecord($fq_user_model->id, $ip);
        }
        return $data;
    }

    /**
     * 生成登录信息
     * @param $user_id
     * @param $client_ip
     * @return array
     */
    public function saveLoginRecord($user_id, $client_ip)
    {
        //生产日志信息
        $login_log_repository = new LoginLogRepository();
        /** @var LoginLogEntity $mobile_log_entity */
        $mobile_log_entity = $login_log_repository->getLoginLogByUserId($user_id);
        if (empty($mobile_log_entity)) {
            $mobile_log_entity = new LoginLogEntity();
            $mobile_log_entity->user_id = $user_id;
        }
        $mobile_log_entity->type = FqUserLoginType::TYPE_PC;
        $mobile_log_entity->ip = $client_ip;
        $login_log_repository->save($mobile_log_entity);
        return $data = [
            "user_id" => $user_id,
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
            $fq_user_entity->password = md5(md5($password) . $fq_user_entity->salt);
            $now = Carbon::now()->format('Y-m-d H:i:s');
            $expire = Carbon::createFromFormat('Y-m-d H:i:s', date("Y-m-d H:i:s", strtotime(" +1 week")))->toDateTimeString();
            $fq_user_entity->expire = $expire;
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
            $fq_user_entity->platform_id = FqUserPlatformType::TYPE_PC;//未知类型
            $fq_user_repository->save($fq_user_entity);
            //手机号注册后，需要自动进入登录状态
            $user_id = $fq_user_entity->id;
            $this->saveLoginRecord($user_id, Request::ip());
            return ['user_id' => $user_id];
        } else {
            throw new LoginException('', $code);
        }
    }


    /**
     * 第三方登录
     * @param $user_data
     * @return array
     */
    public function thirdPartyLogin($user_data)
    {
        $third_party_bind_repository = new ThirdPartyBindRepository();
        $user_info = $user_data->user;
        $third_party_bind_entity = $third_party_bind_repository->getThirdPartyByOpenId($user_info['openid']);

        if (!\Auth::check()) {
            if (isset($third_party_bind_entity)) {
                Auth::loginUsingId($third_party_bind_entity->user_id);
            } else {
                $fq_user_id = $this->thirdPartyRegister($user_info['openid'], $user_info['nickname'], 0);
                Auth::loginUsingId($fq_user_id);
            }
        } else {
            $user = request()->user();
            if (!isset($third_party_bind_entity)) {
                //第三方绑定表插入数据
                $third_party_bind_repository = new ThirdPartyBindRepository();
                $third_party_bind_entity = new ThirdPartyBindEntity();
                $third_party_bind_entity->open_id = $user_info['openid'];
                $third_party_bind_entity->user_id = $user->id;
                $third_party_bind_entity->third_type = FqUserRegisterType::WECHAT;
                $third_party_bind_repository->save($third_party_bind_entity);
            }
        }
    }


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
        $expire = Carbon::createFromFormat('Y-m-d H:i:s', date("Y-m-d H:i:s", strtotime(" +1 week")))->toDateTimeString();
        $fq_user_entity->expire = $expire;
        $fq_user_entity->reg_time = $now;
        $fq_user_entity->role_type = FqUserRoleType::UNKNOWN;
        $fq_user_entity->role_id = 0;
        $fq_user_entity->status = FqUserStatus::NORMAL_USE;// 正常使用
        $fq_user_entity->account_type = FqUserAccountType::TYPE_FREE;//免费账号
        $fq_user_entity->platform_id = 0;//未知类型
        $fq_user_entity->register_type_id = FqUserRegisterType::WECHAT;
        $fq_user_repository->save($fq_user_entity);
        //第三方绑定表插入数据
        $third_party_bind_repository = new ThirdPartyBindRepository();
        $third_party_bind_entity = new ThirdPartyBindEntity();
        $third_party_bind_entity->open_id = $open_id;
        $third_party_bind_entity->user_id = $fq_user_entity->id;
        $third_party_bind_entity->third_type = FqUserRegisterType::WECHAT;
        $third_party_bind_repository->save($third_party_bind_entity);
        return $fq_user_entity->id;
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
            $data = $this->saveLoginRecord($third_party_bind->user_id, Request::ip());
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
                $fq_user_entity->password = md5(md5($password) . $fq_user_repository->findSalt($phone, FqUserAccountStatus::TYPE_MOBILE));
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
                $user_id = request()->user()->id;
                $fq_user_entity = $fq_user_repository->fetch($user_id);
                $fq_user_entity->mobile = $bind_phone_entity->phone;
                $fq_user_repository->save($fq_user_entity);
                return ['success' => true];
            } else {
                throw new LoginException('', $errorCode);
            }
        }
    }

    /**
     * 发送到七牛
     * @param $file
     */
    public function getImage($file)
    {
        $resource_repository = new ResourceRepository();
        $token = $resource_repository->uploadToken(Yii::$app->params['STORAGE_QINIU_DEFAULT_BUCKET']);
        $url = "http://upload.qiniu.com/";
        $post_data = array(
            "token" => $token,
            //"file" => '@'.$targetName
            //"file" => "@/Volumes/ExtraDisk/html/Loki/crossDomainPort/ca.jpg"
            "file"  => new \CURLFile(realpath($file)),
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $image = json_decode($output);
        return $image->id;
    }

    /**
     * @param FqUserEntity $fq_user_entity
     */
    public function getAccountInfo($fq_user_entity)
    {
        $data = [];
        $data['logo_url'] = '/www/images/provider/default_logo.png';
        if ($fq_user_entity->role_type == FqUserRoleType::PROVIDER) {
            $provider_id = $fq_user_entity->role_id;
            $provider_service = new ProviderService();
            $provider = $provider_service->getProviderInfo($provider_id);
            if (!empty($provider)) {
                if (!empty($provider['logo_images'])) {
                    $logo_image = current($provider['logo_images']);
                    $data['logo_url'] = $logo_image['url'] ?? '';
                }
                $data['name'] = $provider['brand_name'];
            }
        } else if ($fq_user_entity->role_type == FqUserRoleType::DEVELOPER) {
            $developer_id = $fq_user_entity->role_id;
            $developer_service = new DeveloperService();
            $developer = $developer_service->getDeveloperInfo($developer_id);
            if (!empty($developer)) {
                $data['logo_url'] = $developer['image_url'];
                $data['name'] = $developer['name'];
            }
        }
        $user_msg_service = new UserMsgService();
        $data['un_read_count'] = $user_msg_service->getUnreadMsgCount($fq_user_entity->id);
        return $data;
    }


}

