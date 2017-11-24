<?php
ufa()->extCss([
    'product/comments'
]);
ufa()->extJs([
    'product/comments',
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <table class="table" cellspacing="0" cellpadding="0">
                <thead>
                <tr>
                    <th width="100">评论人</th>
                    <th width="200">评论时间</th>
                    <th width="460">评论内容</th>
                    <th width="100">操作</th>
                </tr>

                </thead>
                <tbody>
                @foreach(($items ?? []) as $item)
                    <tr>
                        <td>{{$item['user_name'] or ''}}</td>
                        <td>{{$item['time_ago'] or ''}}</td>
                        <td>{{$item['content']}}</td>
                        <td>
                            <a class="delete" href="javascript:0;" data-id="{{$item['id']}}">
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
    @include('common.confirm-pop' ,['type' => 2,'confirm_text' => "这条评论"])
@endsection