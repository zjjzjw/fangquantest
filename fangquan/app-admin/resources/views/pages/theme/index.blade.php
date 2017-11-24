<?php
ufa()->extCss([
    'theme/index'
]);
ufa()->extJs([
    'theme/index',
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">

            <div class="button-box">
                <div class="add">
                    <a href="{{route('theme.edit', ['id' => 0])}}" class="button add-btn">新增关键词</a>
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
                    <div class="row">

                        <div class="small-8 columns">
                            <div class="small-8 columns text-right">
                                <label for="right-label" class="text-right">类别：　</label>
                            </div>
                            <div class="small-14 columns">
                                <select name="type">
                                    <option value="">--请选择类别--</option>
                                    @foreach($types as  $key => $name)
                                        <option
                                                @if(($appends['type'] ?? 0) == $key) selected @endif
                                        value="{{$key}}">{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="columns">
                            <input type="submit" class="btn" value="搜索"/>
                            <a href="{{route('theme.index')}}" class="button reset-btn">重置</a>
                        </div>
                    </div>
                </form>
            </div>

            <table class="table" cellspacing="0" cellpadding="0">
                <thead>
                <tr>
                    <th width="150">序号</th>
                    <th width="300">类别</th>
                    <th width="500">关键词</th>
                    <th width="150">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach(($items ?? []) as $item)
                    <tr>
                        <td>{{$item['order'] or 0}}</td>
                        <td>{{$item['type_name'] or ''}}</td>
                        <td>{{$item['name'] or ''}}</td>
                        <td>
                            <a class="icon-edit" title="编辑" href="{{route('theme.edit',['id'=>$item['id']])}}">
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