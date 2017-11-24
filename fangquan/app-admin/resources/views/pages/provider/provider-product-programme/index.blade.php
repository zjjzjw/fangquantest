<?php
ufa()->extCss([
    'provider/provider-product-programme/index'
]);
ufa()->extJs([
    'provider/provider-product-programme/index',
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        @include('partials.provider.nav',['provider_id' =>$provider_id] ?? 0)
        <div class="content-box">

            <div class="button-box">
                <div class="add-btn">
                    <a href="{{route('provider.provider-product-programme.edit',['id'=>0,'provider_id' =>$provider_id ?? 0])}}"
                       class="button">+ 添加方案</a>
                </div>
            </div>

            <div class="table-box">
                <table class="table" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th width="20%">方案标题</th>
                        <th width="15%">描述</th>
                        <th width="15%">创建时间</th>
                        <th width="10%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items ?? [] as $item)
                        <tr>
                            <td>{{$item['title'] or  ''}}</td>
                            <td>{{$item['desc'] or  ''}}</td>
                            <td>{{$item['created_at'] or ''}}</td>
                            <td>
                                <a title="编辑" class="icon-edit"
                                   href="{{route('provider.provider-product-programme.edit',['id'=>$item['id'] ?? 0 ,'provider_id' =>$item['provider_id'] ?? 0])}}">
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
