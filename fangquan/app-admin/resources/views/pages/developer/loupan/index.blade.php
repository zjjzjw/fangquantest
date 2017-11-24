<?php
ufa()->extCss([
    'developer/loupan/index'
]);
ufa()->extJs([
    'developer/loupan/index',
]);
?>
@extends('layouts.master')
@section('master.content')

    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                <div class="add">
                    <a href="{{route('developer.loupan.edit',['id'=>0])}}" class="button add-btn">+楼盘名称</a>
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
                            <a href="{{route('developer.loupan.index')}}" class="button reset-btn">重置</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-box">
                <table class="table" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th width="10%">编号</th>
                        <th width="10%">省份</th>
                        <th width="10%">城市</th>
                        <th width="30%">所属开发商</th>
                        <th width="30%">楼盘名称</th>
                        <th width="10%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $key => $item)
                        <tr>
                            <td>{{$item['id'] or 0}}</td>
                            <td>{{$item['province_name'] or ''}}</td>
                            <td>{{$item['city_name'] or ''}}</td>
                            <td>{{$item['developer_names'] or ''}}</td>
                            <td>{{$item['name'] or ''}}</td>
                            <td>
                                <a class="icon-edit" title="编辑"
                                   href="{{route('developer.loupan.edit',['id'=>$item['id']])}}">
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
            </div>

            {{--分页--}}
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
