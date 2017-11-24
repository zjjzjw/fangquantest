<div id="header" class="header">
    <div class="public-header">
        <div class="logo">
            <a href=""><img src="/www/images/logo.png" alt=""></a>
        </div>
        <div class="supplice">
            <a href=""
               @if(1)class="type"@endif>找百强开发商项目</a>
            <a href="">找TOP20供应商</a>
            <a target="_blank" href="">APP下载</a>
        </div>
        <div class="login">
            @if(0)
                <a class="lon-in" href=""><i class="iconfont">&#xe73d;</i>登录</a>
                <span>|</span>
                <a class="register" href=""><i class="iconfont">&#xe73d;</i>注册</a>
            @else
                 <a href="" class="messages">
                    <i class="iconfont">&#xe73d;</i>
                    @if(1)
                        <span>1</span>
                    @endif
                </a>
                <a href=""
                   class="nickname"><em>lina</em></a>
                <span>|</span>
                <a class="register" href="">退出</a>
            @endif
        </div>
    </div>
</div>