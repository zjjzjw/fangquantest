<div class="left-box">
    <div class="logo">
        <a href="{{route('personal.home')}}">
            <img src="{{$account_info['logo_url'] or ''}}" alt="">
        </a>
    </div>
    <p class="company-name">{{$account_info['name'] or  ''}}</p>
    <ul class="info-nav">
        <li>

            <a href="{{route('personal.account.account-info')}}">
                <i class="iconfont">&#xe63c;</i>
                账号
            </a>
        </li>
        <li class="messages">
            <a href="{{route('personal.message.list')}}">
                <i class="iconfont">&#xe64b;</i>
                消息
                @if(($account_info['un_read_count'] ?? 0) >  0)
                    <span></span>
                @endif
            </a>
        </li>
        <li>
            <a href="{{route('personal.collection.collection-project')}}">
                <i class="iconfont">&#xe68c;</i>
                收藏
            </a>
        </li>
    </ul>
</div>