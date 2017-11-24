<?php
ufa()->extCss([
    'fq-user/fq-user-feedback/index'
]);
ufa()->extJs([
    'fq-user/fq-user-feedback/index',
]);
ufa()->addParam(
    [
        'id' => 0,
    ]
);
?>
@extends('layouts.master') @section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="table-box">
                <table class="table" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th width="10%">编号</th>
                        <th width="10%">用户昵称</th>
                        <th width="10%">联系方式</th>
                        <th width="30%">反馈内容</th>
                        <th width="10%">来源</th>
                        <th width="10%">反馈时间</th>
                        <th width="10%">状态</th>
                        <th width="10%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $key => $item)
                        <tr>
                            <td>{{$item['id'] or ''}}</td>
                            <td>{{$item['fq_user_name'] or ''}}</td>
                            <td>{{$item['contact'] or ''}}</td>
                            <td>{{$item['content'] or ''}}</td>
                            <td>{{$item['device'] or ''}}</td>
                            <td>{{$item['created_at'] or ''}}</td>
                            <td>{{$item['status_name'] or ''}}</td>
                            <td>
                                <a title="编辑" class="icon-edit"
                                   href="{{route('fq-user.fq-user-feedback.edit',['id'=>$item['id'] ?? 0])}}">
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

                {{--分页--}} @if(!$paginate->isEmpty())
                    <div class="patials-paging">
                        {!! $paginate->appends($appends)->render() !!}
                    </div>
                @endif
            </div>

        </div>
    </div>
    @include('common.prompt-pop',['type'=>1])
    @include('common.confirm-pop' ,['type' => 2,'confirm_text' => ""])
@endsection