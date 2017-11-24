<?php
ufa()->extJs([
    '../lib/Chart',
    'provider/company-info-left'
]);
ufa()->extCss([
    'provider/company-info-left'
]);
ufa()->addParam(
    [
        'fraction'     => $common_data['fraction'] ?? [0, 0, 0, 0, 0],
        'aduitdetails' => $common_data['aduitdetails'] ?? [],
    ]
);
?>
<!--左侧-->
<div class="left-box">
    <!--综合实力-->
    <div class="top-strength">
        <h3>综合实力</h3>
        @foreach($common_data['rank_category'] ?? [] as $rank_category)
            <p class="detail">
                该企业在"{{ $rank_category['category_name'] or '' }}
                "类综合排名为<span>{{ $rank_category['rank'] or 0 }}</span>
            </p>
        @endforeach

        <div class="mesh">
            <canvas id="myChart" width="250" height="250"></canvas>
        </div>
    </div>

    <!--联系方式-->

    <div class="contact">
        <h3>联系方式</h3>
        <div class="information">
            <div class="change-info">
                <p>
                    <i class="iconfont">&#xe60c;</i>
                    <span>···········</span>
                </p>
                <p>
                    <i class="iconfont">&#xe85e;</i>
                    <span>···········</span>
                </p>
                <p>
                    <i class="iconfont">&#xe6e7;</i>
                    <span>···········</span>
                </p>
                <p>
                    <i class="iconfont">&#xe61e;</i>
                    <span>···········</span>
                </p>
            </div>

            @if($common_data['has_contact'])
                <a class="contact-info" href="javascript:;">查看联系方式</a>
            @endif
        </div>
    </div>

    <!--资料下载-->
    @if(!empty($common_data['aduitdetails']))
        <div class="report">
            <h3>资料下载</h3>
            <div class="details">
                <i class="iconfont download-icon">&#xe711;</i>
                <a id="downloadReport" href="javascript:;">
                    <p>下载验厂报告</p>
                    <p class="download"><i class="iconfont">&#xe612;</i></p>
                </a>
            </div>
        </div>
    @endif
    @if(!empty($common_data['news']))
        <div class="company-dynamic">
            <h3>企业动态</h3>
            <ul>
                @foreach($common_data['news'] ?? [] as $news)
                    <li><span class="dot">·</span>
                        <a href="{{ route('provider.company-dynamic.detail',
                        ['provider_id'=> $provider_id ?? 0 , 'news_id' => $news['id'] ?? 0  ]) }}">
                            <p>{{ $news['title'] ?? '' }}</p><span class="time">{{ $news['created_at'] ?? '' }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
            <a class="look-more"
               href="{{ route('provider.company-dynamic.list',['provider_id'=>$provider_id ?? 0]) }}">查看更多</a>
        </div>
    @endif
</div>
<!--下载弹层---->
@if(!empty($common_data['aduitdetails']))
    <script type="text/html" id="downloadTpl">
        <div id="downloadPop">
            <div class="download-pop-box">
                <div class="download-close-box close-box">
                    <a href="javascript:;">
                        <span class="close-btn">X</span>
                    </a>
                </div>
                <div class="download-list">
                    <h3>资料下载</h3>
                    <ul>
                        @foreach($common_data['aduitdetails'] as $aduitdetails)
                            <li class="download-item">
                                <i class="iconfont">&#xe675;</i>
                                <span>{{$aduitdetails['name'] or ''}}</span>
                                <a target="_blank" href="{{$aduitdetails['link_url'] or ''}}">下载</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </script>
@endif
<script type="text/html" id="contact_list_tpl">
    <% if (contacts['telphone'] ) { %>
    <p class="changed-info">
        <i class="iconfont">&#xe60c;</i>
        <span class="telphone"><%=contacts['telphone']%></span>
    </p>
    <% } %>
    <% if (contacts['fax'] ) { %>
    <p class="changed-info">
        <i class="iconfont">&#xe85e;</i>
        <span class="fax"><%=contacts['fax']%></span>
    </p>
    <% } %>
    <% if (contacts['service_telphone'] ) { %>
    <p class="changed-info">
        <i class="iconfont">&#xe6e7;</i>
        <span class="service-telphone"><%=contacts['service_telphone']%></span>
    </p>
    <% } %>
    <% if (contacts['website'] ) { %>
    <a href="<%=contacts['website']%>" target="_blank">
        <p class="changed-info">
            <i class="iconfont">&#xe61e;</i>
            <span class="website"><%=contacts['website']%></span>
        </p>
    </a>
    <% } %>
</script>
