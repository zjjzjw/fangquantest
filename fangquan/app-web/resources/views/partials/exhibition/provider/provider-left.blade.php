<div class="provider-left">
    <div class="left-box">
        <p>联系方式</p>
    </div>
    <div class="bottom-box">
        <ul>
            @if(!empty($brand_sales))
                @foreach($brand_sales as $brand_sale)
                    <li>
                        <ul>

                            <li>{{$brand_sale['type_name'] or ''}}：<span>{{$brand_sale['name'] or ''}}</span></li>
                            <li>联系方式：<span>{{$brand_sale['telphone'] or ''}}</span></li>
                            @if(!empty($brand_sale['sale_area_names']))
                                <li>负责公司区域：<span>{{$brand_sale['sale_area_names'] or ''}}</span></li>
                            @endif
                        </ul>
                    </li>

                @endforeach
            @else
                @include('common.no-data', ['title' => '暂无数据'])
            @endif
        </ul>
    </div>
</div>
