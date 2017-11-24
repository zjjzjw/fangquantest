<div class="wrap-width">
    <div class="brand-info">
        <div class="brand-left">
                <span class="company-logo">
                    @if(0)
                        <img src="" alt="LOGO">
                    @else
                        <img src="/www/images/provider/default_logo.png" alt="LOGO">
                    @endif
                </span>
            <div class="company-info">
                <h3>华龙德</h3>
                <p class="company-name">山东华龙德建材科技有限公司</p>
                <p class="company-detail">
                        <i class="iconfont">&#xe685;</i>
                        <span class="address">
                            山东省济南市
                        </span>
                </p>
                <p class="category-names">
                        <span>保温材料</span>
                        <span>保温材料</span>
                        <span>保温材料</span>
                </p>
            </div>
        </div>
        <div class="brand-right">
            @if(0)
                <a href="javascript:;" class="close-collection" data-id="">
                    <i class="iconfont active">&#xe60c;</i>已收藏
                </a>
            @else
                <a href="javascript:;" class="collection" data-id="">
                    <i class="iconfont">&#xe7c6;</i>加入收藏
                </a>
            @endif
            <a href="javascript:;" class="contrast provider-contrast" data-id=""><i
                        class="iconfont">&#xe60f;</i>加入对比</a>
        </div>
    </div>
    <div class="nav-box">
        <ul>
            <li class="bg-blue">
                @if(1)<div class="triangle-down-blue triangle-down"></div>@endif
                <a href="{{route('provider.enterprise-info', ['provider_id' => 1])}}">企业信息</a>
            </li>
            <li class="bg-red">
                @if(1)<div class="triangle-down-red triangle-down"></div>@endif
                <a href="">工商信息</a>
            </li>
            <li class="bg-orange">
                @if(1)<div class="triangle-down-orange triangle-down"></div>@endif
                <a href="">历史项目</a>
            </li>

            <li class="bg-green">
                @if(1)<div class="triangle-down-green triangle-down"></div>@endif
                <a href="">产品方案</a>
            </li>

            <li class="bg-dark">
                @if(1)<div class="triangle-down-dark triangle-down"></div>@endif
                <a href="">服务网点</a>
            </li>
        </ul>
    </div>
</div>