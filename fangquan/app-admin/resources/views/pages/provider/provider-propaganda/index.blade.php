<?php
ufa()->extCss([
        'provider/provider-propaganda/index'
]);
ufa()->extJs([
        'provider/provider-propaganda/index',
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        @include('partials.provider.nav', ['provider_id' => $provider_id ?? 0])
        <div class="content-box">
            <div class="button-box">
                <div class="add-btn">
                    <a href="{{route('provider.provider-propaganda.edit',['id'=> 0 ,'provider_id' =>$provider_id ?? 0])}}"
                       class="button">+ 添加宣传图片,视频</a>
                </div>
            </div>
            <div class="table-box">

                <table class="table" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th width="30%">图片</th>
                        <th width="30%">外链地址</th>
                        <th width="20%">创建时间</th>
                        <th width="20%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $key => $item)
                        <tr>
                            <td><img src="{{$item['image_url']}}?imageView2/2/w/100/h/100"></td>
                            <td>{{$item['link']  or ''}}</td>
                            <td>{{$item['created_at']  or ''}}</td>
                            <td>

                                <a title="编辑" class="icon-edit" href="{{route('provider.provider-propaganda.edit',
                             ['id' => $item['id'] ?? 0, 'provider_id' => $item['provider_id'] ?? 0]
                            )}}">
                                    <i class="iconfont">&#xe626;</i>
                                </a>
                                <a title="删除" class="delete" data-id="{{$item['id']}}">
                                    <i class="iconfont">&#xe601;</i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{--分页--}}
                @if(!$paginate->isEmpty())
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