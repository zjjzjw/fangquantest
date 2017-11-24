<?php
ufa()->extCss([
    'personal/collection/collection-project'
]);
ufa()->extJs([
    'personal/collection/collection-project'
]);
ufa()->addParam(['token' => csrf_token()]);
?>
@extends('layouts.master')
@section('master.content')
    @include('partials.header')
    <div class="main-content">
        @include('pages.personal.personal-left')
        <div class="right-box">
            @include('pages.personal.collection.nav')
            <div class="tab_box">
                <div class="search">
                    <form action="" method="get">
                        <input type="text" name="keyword" class="search_bar" placeholder="搜索项目"
                               value="{{$appends['keyword'] ?? ''}}">
                        <input type="submit" class="search-btn" value="查询">
                    </form>
                </div>
                @if(!empty($items))
                    <div class="project_list">
                        <p>
                            <span>项目名</span>
                            <span>开发商</span>
                            <span>项目阶段</span>
                        </p>


                        <ul class="list-ul">
                            @foreach($items as $item)
                                <li>

                                    <a target="_blank"
                                       href="{{route('developer.developer-project.detail',['id' => $item['id'] ?? 0])}}">
                                        <span>{{$item['name'] or ''}}</span>
                                        <span>{{$item['developer_name'] or ''}}</span>
                                        <span>{{$item['developer_stage_name'] or ''}}</span>
                                    </a>
                                    <i class="iconfont delete" data-id="{{$item['id'] or 0}}">&#xe65d;</i>

                                </li>
                            @endforeach
                        </ul>
                    </div>
                    {{--分页--}}
                    @if(!$paginate->isEmpty())
                        <div class="patials-paging">
                            {!! $paginate->appends($appends)->render() !!}
                        </div>
                    @endif
                @else
                    @include('common.no-data', ['title' => '暂无数据'])
                @endif
            </div>
        </div>
    </div>
    @include('common.back-top')
    @include('common.prompt-pop',['type'=>1])
    @include('common.confirm-pop' ,['type' => 2,'confirm_text' => ""])
@endsection