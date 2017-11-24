<?php App\Wap\Http\Controllers\Resource::addJS(array('app/exhibition/footer')); ?>
<?php
$url_name = request()->route()->getName();
?>
<div class="footer">
    <div class="exhibition-footer">
        <p class="title">开发商</p>
        <div class="developer-list">
            <ul class="developer-box">
                @foreach($developers ?? [] as $developer)
                    <li>
                        <a href="{{route('exhibition.developer-project.list', ['developer_id' => $developer['id']])}}"><img src="{{$developer['logo_url'] or ''}}" alt=""></a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="clear"></div>
        <div class="btn-box">
            <a href="{{route('exhibition.developer.index')}}" class="more-developer">更多开发商</a>
            <a href="{{route('exhibition.developer-project.list')}}" class="more-developer">更多项目</a>
        </div>
    </div>
    <div class="exhibition-footer">
        <p class="title">供应商</p>
        <div class="developer-list">
            <ul class="provider-box">
                @foreach($providers ?? [] as $provider)
                    <li>
                        <a href="{{route('exhibition.provider.detail', ['id' => $provider['id']])}}"><img src="{{$provider['logo_url'] or ''}}" alt=""></a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="clear"></div>
        <a href="{{route('exhibition.provider.index')}}" class="more-provider">更多供应商</a>
    </div>
    <div class="support-box">
        <ul>
            <li class="special-support">
                <a href="JavaScript:void(0);"><img src="/www/image/exhibition/exhibition-h5/WechatIMG133.jpeg"
                                                   alt=""></a>
                <p>主办单位：中国建材市场协会工程招标采购分会</p>
            </li>
            <li>
                <a href="JavaScript:void(0);"><img src="/www/image/exhibition/exhibition-h5/WechatIMG135.jpeg"
                                                   alt=""></a>
                <p>协办单位：<br>上海绘房信息科技有限公司</p>
            </li>
            <li class="special-support">
                <a href="JavaScript:void(0);"><img src="/www/image/exhibition/exhibition-h5/WechatIMG134.jpeg"
                                                   alt=""></a>
                <p>承办单位：<br>上海檐宇信息咨询有限公司</p>
            </li>
            <li>
                <a href="JavaScript:void(0);"><img src="/www/image/exhibition/exhibition-h5/WechatIMG136.jpeg"
                                                   alt=""></a>
                <p>全程战略合作：<br>方太集团</p>
            </li>
        </ul>
        <div class="clear"></div>
    </div>
    <div class="remark-box">
        <p>上海绘房信息科技有限公司 上海市武宁路423号50智慧产业科技园5号楼2F</p>
        <p>服务热线：4000393009（9：00-18：00）</p>
    </div>
</div>
<script type="text/html" id="developer_tpl">
    <% for ( var k = 0; k < data.length; k++ ) { %>
    <li>
        <a href="/"><img src="<%=data[k].logo_url%>" alt=""></a>
    </li>
        <% } %>
    </script>
    <script type="text/html" id="provider_tpl">
    <% for ( var k = 0; k < data.length; k++ ) { %>
    <li>
        <a href="/"><img src="<%=data[k].logo_url%>" alt=""></a>
    </li>
        <% } %>
    </script>