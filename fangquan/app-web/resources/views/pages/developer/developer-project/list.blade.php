<?php
ufa()->extCss([
        'developer/developer-project/list'
]);
ufa()->extJs([
        'developer/developer-project/list'
]);
?>
@extends('layouts.master')
@section('master.content')
    @include('partials.header')
    <div class="main-content">

        <div class="left-box">
            <div class="search-box">
                <form method="GET" action="" id="">
                    <i class="iconfont">&#xe600;</i>
                    <input type="text" name="keyword" placeholder="请输入项目名、百强开发商名"
                           value="{{$appends['keyword'] or ''}}">
                    <input type="submit" value="搜索">
                </form>
            </div>

            <div class="screen">
                <div class="s_line">
                    <div class="sl_key">
                        <a href="JavaScript:;">所需材料</a>
                    </div>
                    <ul class="sl_value">
                        <li>
                            <a href="{{route('developer.developer-project.list',
                            array_merge($appends, ['product_category_id' => 0 ]))}}"
                               class="@if(($appends['product_category_id'] ?? 0) == 0) active @endif">
                                全部
                            </a>
                        </li>
                        @foreach($product_categories as $product_category)
                            <li>
                                <a href="{{route('developer.developer-project.list',
                            array_merge($appends, ['product_category_id' => $product_category['id']]))}}"
                                   class="@if(($appends['product_category_id'] ?? 0) == $product_category['id']) active @endif"
                                >
                                    {{$product_category['name'] or  ''}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="s_line">
                    <div class="sl_key">
                        <a href="JavaScript:;">所在地</a>
                    </div>
                    <ul class="sl_value">
                        <li>
                            <a href="{{route('developer.developer-project.list',array_merge($appends, ['province_id' => 0 ]))}}"
                               class="fist @if(($appends['china_area_id'] ?? 0) == 0) active @endif">全部</a>
                        </li>
                        @foreach($china_areas as $china_area)
                            @if(!empty($china_area['provinces']))
                                <li class="sl_more">
                                    <a href="javascript:;"
                                       class="filter_one @if(($appends['china_area_id'] ?? 0) == $china_area['id']) active @endif">
                                        @if(($appends['china_area_id'] ?? 0) == $china_area['id'])
                                            {{$appends['province_name'] or  ''}}
                                        @else
                                            {{$china_area['name'] or ''}}
                                        @endif
                                        <i class="iconfont">&#xe614;</i>
                                    </a>
                                    @if(!empty($china_area['provinces']))
                                        <ul class="sl_tab_cont">
                                            @foreach($china_area['provinces'] as $province)
                                                <li>
                                                    <a class=""
                                                       href="{{route( 'developer.developer-project.list',array_merge($appends,['province_id' => $province['id']]) )}}">
                                                        {{$province['name'] or  ''}}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>

                <div class="s_line">
                    <div class="sl_key">
                        <a href="JavaScript:;">项目阶段</a>
                    </div>
                    <ul class="sl_value">
                        <li>
                            <a href="{{route('developer.developer-project.list',
                            array_merge($appends, ['project_stage_id' => 0]))}}"
                               class="@if(($appends['project_stage_id'] ?? 0) == 0) active @endif">全部</a>
                        </li>
                        @foreach($developer_project_stages as $developer_project_stage)
                            <li>
                                <a href="{{route('developer.developer-project.list',
                            array_merge($appends, ['project_stage_id' => $developer_project_stage['id']]))}}"
                                   class="@if(($appends['project_stage_id'] ?? 0) == $developer_project_stage['id']) active @endif">
                                    {{$developer_project_stage['name']}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="list-content">
                <div class="sort">
                    <div class="left">
                        <a href="{{route('developer.developer-project.list',
                        array_merge($appends, ['column' => 'updated_at', 'sort' => 'desc']))}}"
                           class="@if($appends['column'] == 'updated_at') active @endif">默认</a>

                        <a href="{{route('developer.developer-project.list',
                        array_merge($appends, ['column' => 'time', 'sort' => 'desc']))}}"
                           class="@if($appends['column'] == 'time') active @endif">发布时间<i
                                    class="iconfont">&#xe648;</i></a>

                        <a href="{{route('developer.developer-project.list',
                        array_merge($appends, ['column' => 'cost', 'sort' => 'desc']))}}"
                           class="@if($appends['column'] == 'cost') active @endif">造价<i
                                    class="iconfont">&#xe648;</i></a>
                    </div>

                    <div class="right">
                        <p>共 <span>{{$pager['total'] or  '0'}}</span> 条记录</p>
                    </div>
                </div>

                @if(!empty($items))
                    <ul class="list-item">
                        <?php $i = 1;?>
                        @foreach($items as $item)
                                <li>
                                    <a target="_blank"
                                       href="{{route('developer.developer-project.detail', ['developer_project_id' => $item['id']])}}">
                                        <i class="@if($item['is_read'] == 'true') bg-top4 @elseif($item['rank'] <= 3) bg-top{{$item['rank']}} @else bg-top @endif">{{$item['rank'] or  '1'}}</i>
                                        <div class="bq-project">
                                            <div class="bq-logo">
                                                <img src="{{$item['logo_url'] or ''}}?imageView2/2/w/94" class="@if($item['is_read'] == 'true') change-logo @endif">
                                            </div>
                                            <div class="info-aside">
                                                <h3 class="@if($item['is_read'] == 'true') change-name @endif">{{$item['name'] or  ''}}</h3>
                                                <p class="@if($item['is_read'] == 'true') change-developer-name @endif">{{$item['developer_name'] or ''}}</p>
                                                <p class="manufacturing @if($item['is_read'] == 'true') change-manufacturing @endif">造价：<span>{{$item['cost']}}万元</span></p>
                                                <p class="project-phase @if($item['is_read'] == 'true') change-project-phase @endif">项目阶段：<span>{{$item['developer_stage_name']}}</span>
                                                </p>
                                            </div>
                                        </div>

                                        <p class="bq-data">
                                <span class="data @if($item['is_read'] == 'true') change-data @endif">
                                    <i class="iconfont @if($item['is_read'] == 'true') change-iconfont @endif">&#xe69a;</i>
                                    {{$item['time'] or ''}}
                                </span>
                                            @if(!empty($item['city']['name']))
                                                <span class="city @if($item['is_read'] == 'true') change-city @endif">
                                        <i class="iconfont @if($item['is_read'] == 'true') change-iconfont @endif">&#xe629;</i>
                                                    {{$item['city']['name'] or  ''}}
                                    </span>
                                            @endif
                                        </p>
                                    </a>
                                </li>
                            <?php $i++; ?>
                        @endforeach
                    </ul>
                    {{--分页--}}
                    @if(!$paginate->isEmpty())
                        <div class="patials-paging">
                            {!! $paginate->appends($appends)->render() !!}
                        </div>
                    @endif
                @else
                    @include('common.no-data',['title'=>'这句是搜索不到结果的文案'])
                @endif
            </div>
        </div>
        <div class="right-box">
            @if(!empty($ad_developer_projects))
                <h3>推荐项目</h3>
                <ul>
                    @foreach($ad_developer_projects as $ad_developer_project)
                        <li>
                            <a href="{{route('developer.developer-project.detail',['id'=>$ad_developer_project['id']])}}">
                                <div class="project-logo">
                                    <img src="{{$ad_developer_project['logo_url'] or ''}}" alt="">
                                </div>
                                <p>{{$ad_developer_project['name']}}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
            <a href="{{route('developer.list')}}">查看百强开发商</a>
        </div>
        @include('common.back-top')
    </div>
@endsection