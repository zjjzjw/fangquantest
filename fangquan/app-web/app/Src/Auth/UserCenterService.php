<?php namespace App\Web\Src\Auth;

use App\Src\FqUser\Domain\Model\FqUserStatus;

class UserCenterService
{
    const LOGIN_ERROR_MSG_KEY = 'login_error_msg';


    public function login($credentials)
    {
        $result = $this->userLogin($credentials);
        if (isset($result['msg'])) {
            $this->storeLoginErrorMsg($result['msg']);
            return null;
        }
        if (isset($result['user_id'])) {
            return $result['user_id'];
        }
        return null;
    }


    public function getMd5Password($password, $salt)
    {
        return md5(md5($password) . $salt);
    }

    public function userLogin($credentials)
    {
        //登录代码
        $data = [];
        $builder = \App\Web\User::query();
        if (isset($credentials['account'])) {
            $builder->where('account', $credentials['account'])
                ->orWhere('mobile', $credentials['account']);
        } else {
            $builder->where('mobile', $credentials['mobile']);
        }
        $model = $builder->first();
        if (!isset($model)) {
            $data['msg'] = '用户不存在。';
        } else {
            $data['user_id'] = $model->id;
            if ($model->status == FqUserStatus::DISABLE) {
                $data['msg'] = '账户禁用。';
            }
            if ($model->status == FqUserStatus::NO_ACTIVE) {
                $data['msg'] = '账户未激活。';
            }
            $password = $model->password;
            $salt = $model->salt;
            if ($password !== $this->getMd5Password($credentials['password'], $salt)) {
                $data['msg'] = '密码错误。';
            }
        }
        return $data;
    }


    /**
     * 获取登录失败信息
     *
     * @return string
     */
    public function getFailedLoginMessage()
    {
        return session(self::LOGIN_ERROR_MSG_KEY);
    }

    /**
     * 存储登录错误信息
     *
     * @param $msg
     *
     * @return mixed
     */
    protected function storeLoginErrorMsg($msg)
    {
        return session()->flash(self::LOGIN_ERROR_MSG_KEY, $msg);
    }


}