<?php
ufa()->extCss([
        'developer/developer/index'
]);
ufa()->extJs([
        'developer/developer/index',
]);
?>
@extends('layouts.master')
@section('master.content')

    <div class="wrapper-box">
        <div id="contain">
            <div class="filter-box">
                <div class="add">
                    <a href="{{route('developer.developer.edit',['id'=>0])}}" class="button add-btn">+开发商</a>
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

                        <div class="small-8 columns">
                            <div class="small-8 columns text-right">
                                <label for="right-label" class="text-right">状态：</label>
                            </div>
                            <div class="small-14 columns">
                                <select name="status">
                                    <option value="">--请选择--</option>
                                    @foreach(($developer_status ?? []) as $key => $name)
                                        <option value="{{$key}}"
                                                @if(($appends['status'] ?? 0) == $key) selected @endif
                                        >{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="columns">
                            <input type="submit" class="btn" value="搜索"/>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-box">
                <table class="table" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th width="5%">编号</th>
                        <th width="20%">公司名称</th>
                        <th width="20%">logo</th>
                        <th width="10%">状态</th>
                        <th width="20%">创建时间</th>
                        <th width="10%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{$item['id'] or 0}}</td>
                            <td>{{$item['name'] or ''}}</td>
                            <td><img src="{{($item['logo_url'] ?? '').'?imageView2/2/w/100/h/100'}}"></td>
                            <td>{{$item['status_name'] or ''}}</td>
                            <td>{{$item['created_at'] or ''}}</td>
                            <td>
                                <a class="icon-edit" title="项目列表"
                                   href="{{route('developer.developer-project.index',['developer_id'=>$item['id']])}}"><i
                                            class="iconfont">&#xe638;</i></a>
                                <a class="icon-edit" title="编辑"
                                   href="{{route('developer.developer.edit',['id'=>$item['id']])}}">
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
        </div>
        {{--分页--}}
        @if(!$paginate->isEmpty())
            <div class="patials-paging">
                {!! $paginate->appends($appends)->render() !!}
            </div>
        @endif

    </div>

    @include('common.prompt-pop',['type'=>1])
    @include('common.confirm-pop' ,['type' => 2,'confirm_text' => "这条数据"])
@endsection