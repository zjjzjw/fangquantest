<script type="text/html" id="projectTpl">
    @foreach($items ?? [] as $k => $item)
    <div class="project-detail" data-index="{{$k}}" style="display: none;">
        <div class="close-box">
            <a href="javascript:;">
                <span class="close-btn">X</span>
            </a>
        </div>
        <div id="project-swiper-box" class="swiper-common">
            <div id="play" class="big-images">
                <ul class="img_ul project-slide">
                    @foreach($item['provider_project_pictures'] as $image)
                        <li>
                            <a class="img_a">
                                <img src="{{$image['url']}}">
                            </a>
                        </li>
                    @endforeach
                </ul>
                <a href="javascript:void(0)" class="prev_a change_a" title="上一张"><span></span></a>
                <a href="javascript:void(0)" class="next_a change_a" title="下一张"><span
                            style="display:block;"></span></a>
            </div>
            <div class="img_hd small-images">
                <div class="report-thumb">
                    <ul class="clearfix">
                        @foreach($item['provider_project_pictures'] as $image)
                            <li>
                                <a class="img_a">
                                    <img src="{{$image['url']}}">
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <a class="bottom_a prev_a" style="opacity:0.7;"><i class="iconfont icon-left">&#xe644;</i></a>
                <a class="bottom_a next_a" style="opacity:0.7;"><i class="iconfont icon-right">&#xe644;</i></a>
            </div>
        </div>
        <div class="detail-item">
            <p class="product-name">{{$item['name']}}</p>
            <div class="compant-detail">
                <p class="developer">开发商：{{$item['developer_name']}}</p>
                @if(!empty($item['province']['name']) || !empty($item['city']['name']))
                <p>
                    所在地：{{$item['province']['name'] or ''}}&nbsp;&nbsp;{{$item['city']['name'] or ''}}</p>
                @endif
                @if(!empty($item['time']))
                <p>合同签订时间：{{$item['time'] or ''}}</p>
                @endif
            </div>
            @if(!empty($item['provider_project_products']))
            <div class="provider-products">
                <p class="title">供应产品：</p>
                @foreach($item['provider_project_products'] as $products)
                <p class="product-item">{{$products['name']}}：{{$products['num']}}{{$products['measureunit']}}</p>
                @endforeach
            </div>
            @endif
        </div>
    </div>
    @endforeach
</script>