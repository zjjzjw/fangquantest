<script type="text/html" id="loginTpl">
    <div class="hint-close"><i class="iconfont">&#xe676;</i></div>
    <div class="hint-title">
        <span>登录</span>
    </div>
    <div class="hint-content">
        <form id="login_form" method="POST" onsubmit="return false">
            <div class="form-group">
                <label class="control-label">
                    <i class="iconfont">&#xe663;</i>
                </label>
                <div>
                    <input type="text" name="account" value="" maxlength="32"
                           placeholder="请输入手机号/用户名"
                           data-validation="required length"
                           data-validation-length="max32"
                           data-validation-error-msg="请输入手机号/用户名"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">
                    <i class="iconfont">&#xe637;</i>
                </label>
                <div>
                    <input type="password" name="password" value=""
                           placeholder="请输入密码"
                           data-validation="required"
                           data-validation-error-msg="请输入密码"/>
                </div>
            </div>
            <p class="msg-message"></p>
            <div class="form-group">
                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                <input type="submit" class="btn" value="登录"/>
            </div>
        </form>
        <div class="login-link">
            <a href="{{route('auth.weixin')}}" class="wechat">
                <i class="iconfont">&#xe606;</i>微信登录
            </a>
            <a href="{{route('reset-password.reset-password')}}" class="forgot-password">忘记密码？</a>
            <a href="{{route('register')}}" class="register">立即注册</a>
        </div>
    </div>
</script>