<div id="header" class="header">
    <div class="public-header">
        <div class="logo">
            <a href="/"><img src="/www/images/logo.png" alt=""></a>
        </div>
        <div class="supplice">
            <a href="{{route('developer.developer-project.list')}}"
               @if(str_contains(request()->route()->getName(),'developer'))class="type"@endif>
                找百强开发商项目
            </a>
            <a href="{{route('provider.list')}}"
               @if(str_contains(request()->route()->getName(),'provider'))class="type"@endif>
                找TOP20供应商
            </a>
            {{--<a target="_blank" href="">APP下载</a>--}}
        </div>
        <div class="login">

            @if(empty($basic_data['user']))
                <a class="lon-in" href="{{route('login')}}"><i class="iconfont">&#xe63c;</i>登录</a>
                <span>|</span>
                <a class="register" href="{{route('register')}}"><i class="iconfont">&#xe60e;</i>注册</a>
            @else
                <a href="{{route('personal.message.list')}}" class="messages">
                    <i class="iconfont">&#xe64b;</i>
                    @if(($basic_data['login_info']['msg_unread_count'] ?? 0)> 0)
                        <span></span>
                    @endif
                </a>
                <a href="{{route('personal.home')}}"
                   class="nickname"><em>{{$basic_data['user']->nickname or ''}}</em></a>
                <span>|</span>
                <a class="register" href="{{route('logout')}}">退出</a>
            @endif
        </div>
    </div>
</div>