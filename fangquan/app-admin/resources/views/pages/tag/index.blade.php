<?php
ufa()->extCss([
    'tag/index'
]);
ufa()->extJs([
    'tag/index',
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                <div class="add-btn">
                    <a href="{{route('tag.edit',['id' => 0])}}">新增标签</a>
                </div>
            </div>
            <table class="table" cellspacing="0" cellpadding="0">
                <thead>
                <tr>
                    <th width="150">序号</th>
                    <th width="300">类别</th>
                    <th width="500">标签</th>
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
                            <a class="icon-edit" title="编辑" href="{{route('tag.edit',['id'=>$item['id']])}}">
                                <i class="iconfont">&#xe626;</i>
                            </a>
                            <a data-id="{{$item['id'] or 0}}" title="删除" class="delete">
                                <i class="iconfont">&#xe601;</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if(!$paginate->isEmpty())
                <div class="patials-paging">
                    {!! $paginate->render() !!}
                </div>
            @endif
        </div>
    </div>
    @include('common.prompt-pop',['type'=>1])
    @include('common.confirm-pop' ,['type' => 2,'confirm_text' => "这条数据"])
@endsection