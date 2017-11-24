<?php
ufa()->extCss([
    'exhibition/developer-project-list'
]);
ufa()->extJs([
    'exhibition/developer-project-list'
]);
?>
@extends('layouts.master')
@section('master.content')
    @include('partials.exhibition.header')
    <div class="developer-project-list">
        <div class="select-box">
            <div class="select-type">
                <div class="type">
                    <span>招标类型</span>
                </div>
                <ul>
                    <li><a class="  @if(($appends['bidding_type'] ?? 0) == 0) active @endif"
                           href="{{route( 'exhibition.developer-project-list',array_merge($appends,['bidding_type' => '']) )}}">全部</a>
                    </li>
                    @foreach(($developer_project_bidding_type ?? []) as $key=> $value)
                        <li><a class="@if(($appends['bidding_type'] ?? 0) == $key) active @endif"
                               href="{{route( 'exhibition.developer-project-list',array_merge($appends,['bidding_type' => $key]) )}}">{{$value or ''}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="select-type">
                <div class="type">
                    <span>招标品类</span>
                </div>
                <ul class="level-box">
                    <li class="first-box"><a class=" @if(($appends['project_category_id'] ?? 0) == 0) active @endif"
                                             href="{{route( 'exhibition.developer-project-list',array_merge($appends,['project_category_id' => '']) )}}">全部</a>
                    </li>
                    @foreach(($project_main_category ?? []) as $key =>$value)
                        <li class="first-box">
                            <a href="javascript:void(0);"
                               class="first-level  @if(in_array($appends['project_category_id'] ?? 0,$value['node_ids'] )) active @endif ">{{$value['name'] or ''}}</a>

                            <div class="second-content" style="display: none;">
                                <ul class="second-box">
                                    @foreach(($value['nodes'] ?? []) as $node)
                                        <li class="second-level">
                                            <a href="{{route( 'exhibition.developer-project-list',array_merge($appends,['project_category_id' => $node['id']]) )}}">{{$node['name'] or ''}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="select-type">
                <div class="type">
                    <span>所在地</span>
                </div>
                <ul class="level-box">
                    <li class="first-box"><a class="@if(($appends['province_id'] ?? 0) == 0) active @endif"
                                             href="{{route( 'exhibition.developer-project-list',array_merge($appends,['province_id' => '']) )}}">全部</a>
                    </li>
                    @foreach(($china_areas ?? []) as $key =>$china_area)
                        <li class="first-box">
                            <a href="javascript:void(0);"
                               class="first-level @if(($appends['china_area_id'] ?? 0) == $china_area['id']) active @endif ">{{$china_area['name']}}</a>
                            <div class="second-content" style="display: none;">
                                <ul class="second-box">

                                    @foreach(($china_area['provinces'] ?? []) as $key =>$province)
                                        <li class="second-level">
                                            <a href="{{route( 'exhibition.developer-project-list',array_merge($appends,['province_id' => $province['id'],'china_area'=>$china_area['id']]) )}}">{{$province['name'] or ''}}</a>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
        <div class="project-list">
            @if(!empty($items))
                <ul>
                    @foreach(($items ?? []) as $key =>$item)
                        <li>

                            <a target="_blank"
                               href="{{route('exhibition.developer.developer-detail', ['developer_project_id' => $item['id']])}}">
                                <div class="project-info">
                                    <img src="{{$item['logo_url'] or ''}}">
                                    <div class="detail">
                                        <p class="title">{{$item['name'] or ''}}</p>
                                        <p class="name">{{$item['developer_name'] or ''}}</p>
                                        <p class="area">建筑面积：{{$item['floor_space'] or ''}} 平方米</p>
                                        <p class="tender-type">招标类型：{{$item['bidding_type_name'] or ''}}</p>
                                        <p class="project-type">项目类型：{{$item['project_category_name'] or ''}}</p>
                                    </div>
                                </div>
                                <div class="other">
                                    <p class="time">{{$item['time'] or ''}}</p>
                                    <div class="address">
                                        <i class="iconfont">&#xe6bf;</i>
                                        <span>{{$item['city_name'] or ''}}</span>
                                    </div>
                                </div>
                            </a>
                        </li>

                    @endforeach
                </ul>
            @else
                @include('common.no-data',['title'=>'暂无内容'])
            @endif

        </div>
        {{--分页--}}

        @if(!$paginate->isEmpty())
            <div class="patials-paging">
                {!! $paginate->appends($appends)->render() !!}
            </div>
        @endif
    </div>
@endsection