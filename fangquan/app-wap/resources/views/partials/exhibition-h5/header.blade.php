<?php App\Wap\Http\Controllers\Resource::addJS(array('app/exhibition/herader')); ?>
<?php
$url_name = request()->route()->getName();
?>
<div class="exhibition">
    <div class="exhibition-header">
        <div class="logo">
            <a href="/"><img src="/www/image/exhibition/exhibition-h5/exhibition-logo2.png" alt=""></a>
            <div class="title">
                <p class="name">2017首届房地产全产业链B2B创新采购展</p>
                <p class="translate-name">The First B2B Innovation Procurement Exhibition Of Real Estate Whole
                    Industrial Chain</p>
                <p class="time">中国·上海 国家会展中心|2017.12.06</p>
            </div>
        </div>
    </div>
    <div id="search-box" class="search-box">
        <div class="search">
            <form class="search-input" onsubmit="return false;">
                <div class="content-wrap">
                    <a class="link-type" href="javascript:void(0);"><span>开发商</span><i></i></a>
                    <div class="choose-type" style="display: none;">
                        <a href="javascript:void(0);"><span>开发商</span><i></i></a>
                        <a href="javascript:void(0);"><span>供应商</span></a>
                    </div>
                    <input type="text" name="keyword" placeholder='开发商名' id="keyword" class="keyword"
                           value="{{$appends['keyword'] or ''}}">
                    <span class="btn">搜索</span>
                </div>
            </form>
        </div>
    </div>
    <div class="carousel">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach($banners['all_images'] ?? [] as $banner)
                    <div class="swiper-slide">
                        <a href="javascript:void(0);"><img src="{{$banner['url'] ?? ''}}" alt=""> </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="nav-box">
        <ul>
            <li class="@if($url_name == 'exhibition.exhibition-h5.exhibition-h5') active @endif">
                <a href="{{route('exhibition.exhibition-h5.exhibition-h5')}}">首页</a>
            </li>
            <li class="@if($url_name == 'exhibition.flashback.index') active @endif">
                <a href="{{route('exhibition.flashback.index')}}">展会概况</a>
            </li>
            <li class="@if($url_name == 'exhibition.service') active @endif">
                <a href="{{route('exhibition.service')}}">展会服务</a>
            </li>
            <li class="@if($url_name == 'review.list') active @endif">
                <a href="{{route('review.list')}}">展会回顾</a>
            </li>
            <li class="@if($url_name == 'exhibition.result') active @endif">
                <a href="{{route('exhibition.result')}}">展会成果</a>
            </li>
            <li class="@if($url_name == 'station.contact') active @endif">
                <a href="{{route('station.contact')}}">联系我们 </a>
            </li>
        </ul>
    </div>
    <div class="clear"></div>

</div>