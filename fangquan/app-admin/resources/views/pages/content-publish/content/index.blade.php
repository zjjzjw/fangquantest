<?php
ufa()->extCss([
    'content-publish/content/index'
]);
ufa()->extJs([
    'content-publish/content/index',
]);
?>
@extends('layouts.master')
@section('master.content')

    <div class="wrapper-box">
        <div class="content-box">


            <div class="button-box">
                <div class="add">
                    <a href="{{route('content-publish.content.edit',['id'=>0])}}" class="button add-btn">添加内容</a>
                </div>
            </div>

            <div class="search-box">

                @if (count($errors) > 0)
                    <p class="error-alert">
                        @foreach ($errors->all() as $key => $error)
                            {{$key + 1}}、 {{ $error }}
                        @endforeach
                    </p>
                @endif

                <form method="GET" action="" id="">
                    <div class="row">
                        <div class="small-8 columns">
                            <div class="small-8 columns text-right">
                                <label for="right-label" class="text-right">标题：</label>
                            </div>
                            <div class="small-14 columns">
                                <input type="text" name="keyword" value="{{$appends['keyword'] or ''}}" placeholder="请输入标题">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="columns">
                            <input type="submit" class="btn" value="搜索"/>
                            <a href="{{route('content-publish.content.index')}}" class="button reset-btn">重置</a>
                        </div>
                    </div>
                </form>
            </div>


            <div class="table-box">
                <table class="table" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th width="5%">编号</th>
                        <th width="20%">标题</th>
                        <th width="10%">作者</th>
                        <th width="30%">备注</th>
                        <th width="10%">分类</th>
                        <th width="10%">发布时间</th>
                        <th width="10%">状态</th>
                        <th width="5%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(($items ?? [] ) as $item)
                        <tr>
                            <td>{{$item['id'] or ''}}</td>
                            <td>{{$item['title'] or ''}}</td>
                            <td>{{$item['author'] or ''}}</td>
                            <td>{{$item['remake'] or ''}}</td>
                            <td>{{$item['type_name'] or ''}}</td>
                            <td>{{$item['publish_time'] or ''}}</td>
                            <td>{{$item['status_name'] or ''}}</td>
                            <td>
                                <a title="编辑" class="icon-edit"
                                   href="{{route('content-publish.content.edit',['id' => $item['id'] ?? 0])}}">
                                    <i class="iconfont">&#xe626;</i>
                                </a>
                                <a title="删除" class="delete" data-id="{{$item['id'] or ''}}">
                                    <i class="iconfont">&#xe601;</i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        {{--分页--}}
        @if(!$paginate->isEmpty())
            <div class="patials-paging">
                {!! $paginate->render() !!}
            </div>
        @endif
    </div>

    @include('common.prompt-pop',['type'=>1])
    @include('common.confirm-pop' ,['type' => 2])
@endsection