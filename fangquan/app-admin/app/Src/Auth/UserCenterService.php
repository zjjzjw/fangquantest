<?php namespace App\Admin\Src\Auth;

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
        if (!$salt) {
            $salt = config('auth.salt');
        }
        return md5(md5($password) . $salt);
    }

    public function userLogin($credentials)
    {
        //登录代码
        $data = [];
        $builder = \App\Admin\User::query();
        $builder->where('account', $credentials['name']);


        $model = $builder->first();
        if (!isset($model)) {
            $data['msg'] = '用户不存在!';
        } else {
            $data['user_id'] = $model->id;
            $password = $model->password;
            if ($password !== $this->getMd5Password($credentials['password'], $model->salt)) {
                $data['msg'] = '密码错误!';
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