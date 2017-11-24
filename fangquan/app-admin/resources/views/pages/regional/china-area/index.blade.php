<?php
ufa()->extCss([
    'regional/china-area/index',
]);
ufa()->extJs([
    'regional/china-area/index'
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                <div class="add-btn">
                    <a href="{{route('regional.china-area.edit',['id'=> 0])}}" class="button">+ 添加区域</a>
                </div>
            </div>
            <div class="table-box">
                <table class="table" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th width="30%">#</th>
                        <th width="50%">区域名称</th>
                        <th width="20%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(($items ?? []) as $item)
                    <tr>
                        <td>{{$item['id'] or 0}}</td>
                        <td>{{$item['name'] or ''}}</td>
                        <td>
                            <a title="编辑" class="icon-edit"
                               href="{{route('regional.china-area.edit',['id'=> $item['id']])}}">
                                <i class="iconfont">&#xe626;</i>
                            </a>
                            <a href="JavaScript:void(0);" title="删除" class="delete" data-id="{{$item['id']}}">
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