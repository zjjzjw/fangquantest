<?php
ufa()->extCss([
    'information/index'
]);
ufa()->extJs([
    'information/index',
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                <div class="add-btn">
                    <a href="{{route('information.edit',['id'=>0])}}">新增文章</a>
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

                <form method="GET">
                    <div class="row top-box">
                        <div class="small-8 columns">
                            <div class="small-8 columns text-right">
                                <label for="right-label" class="text-right">关键字：</label>
                            </div>
                            <div class="small-14 columns">
                                <input type="text" name="keyword" value="{{$appends['keyword'] or ''}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="columns">
                            <input type="submit" class="btn" value="搜索"/>
                            <a href="{{route('information.index')}}" class="button reset-btn">重置</a>
                        </div>
                    </div>
                </form>
            </div>

            <table class="table" cellspacing="0" cellpadding="0">
                <thead>
                <tr>
                    <th width="150">编号</th>
                    <th width="250">文章名称</th>
                    <th width="200">评论</th>
                    <th width="250">发布时间</th>
                    <th width="150">是否发布</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach(($items ?? []) as $item)
                    <tr>
                        <td>{{$item['id']}}</td>
                        <td>{{$item['title'] or ''}}</td>
                        <td>
                            <a href="{{route('information.comments',['id'=>$item['id']])}}">
                                {{$item['comment_count'] or 0}}
                            </a>
                        </td>
                        <td>{{$item['publish_at'] or ''}}</td>
                        <td>{{$item['status_name'] or ''}}</td>
                        <td>
                            <a class="icon-edit" title="编辑" href="{{route('information.edit',['id'=>$item['id']])}}">
                                <i class="iconfont">&#xe626;</i>
                            </a>
                            <a data-id="{{$item['id']}}" title="删除" class="delete">
                                <i class="iconfont">&#xe601;</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if(!$paginate->isEmpty())
                <div class="patials-paging">
                    {!! $paginate->appends($appends)->render() !!}
                </div>
            @endif
        </div>
    </div>
    @include('common.prompt-pop',['type'=>1])
    @include('common.confirm-pop' ,['type' => 2,'confirm_text' => "这条数据"])
@endsection