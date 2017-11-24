<?php
ufa()->extCss([
        'advertisement/index'
]);
ufa()->extJs([
        'advertisement/index',
]);
?>
@extends('layouts.master')
@section('master.content')

    <div class="wrapper-box">
    <div id="contain">
        <div class="filter-box">
            <div class="add">
                <a href="{{route('advertisement.advertisement.edit',['id'=>0])}}" class="button add-btn">+广告</a>
            </div>
        </div>

        <div class="table-box">
            <table class="table" cellspacing="0" cellpadding="0">
                <thead>
                <tr>
                    <th width="5%">编号</th>
                    <th width="20%">标题</th>
                    <th width="20%">图标</th>
                    <th width="10%">状态</th>
                    <th width="20%">创建时间</th>
                    <th width="10%">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{$item['id'] or 0}}</td>
                        <td>{{$item['title'] or ''}}</td>
                        <td><img src="{{($item['image_url'] ?? '').'?imageView2/1/w/100/h/100'}}"></td>
                        <td>{{$item['status_name'] or ''}}</td>
                        <td>{{$item['created_at'] or ''}}</td>
                        <td>
                            <a class="icon-edit" title="编辑" href="{{route('advertisement.advertisement.edit',['id'=>$item['id']])}}">
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
    </div>
    {{--分页--}}
    @if(!$paginate->isEmpty())
        <div class="patials-paging">
            {!! $paginate->render() !!}
        </div>
    @endif
    @include('common.prompt-pop',['type'=>1])
    @include('common.confirm-pop' ,['type' => 2,'confirm_text' => "这条数据"])
@endsection