<?php
ufa()->extCss([
    'msg/user-msg/index'
]);
ufa()->extJs([
    'msg/user-msg/index',
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">

            <div class="button-box">
                <div class="add-btn">
                    <a href="{{route('msg.user-msg.send', ['id' => $id ?? 0])}}"
                       class="button">+ 发送消息</a>
                </div>
            </div>

            <div class="table-box">
                <table class="table" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th width="5%">标识</th>
                        <th width="15%">发送人</th>
                        <th width="15%">接收人</th>
                        <th width="15%">状态</th>
                        <th width="15%">阅读时间</th>
                        <th width="15%">发送时间</th>
                        <th width="10%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items ?? [] as $item)
                        <tr>
                            <td>{{$item['id'] or  ''}}</td>
                            <td>{{$item['from_user_name'] or  ''}}</td>
                            <td>{{$item['to_user_name'] or  ''}}</td>
                            <td>{{$item['status_name'] or  ''}}</td>
                            <td>{{$item['read_at'] or  ''}}</td>
                            <td>{{$item['created_at'] or ''}}</td>
                            <td>
                                <a title="详情" class="icon-edit"   href="{{route('msg.user-msg.send',['id'=> $item['id'] ])}}">
                                    <i class="iconfont">&#xe61b;</i>
                                </a>
                                <a title="删除" class="delete" data-id="{{$item['id']}}">
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
    @include('common.confirm-pop' ,['type' => 2,'confirm_text' => ""])
@endsection
