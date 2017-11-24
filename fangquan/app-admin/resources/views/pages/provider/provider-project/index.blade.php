<?php
ufa()->extCss([
        'provider/provider-project/index'
]);
ufa()->extJs([
        'provider/provider-project/index',
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        @include('partials.provider.nav',['provider_id' => $provider_id ?? 0])
        <div class="content-box">
            <div class="button-box">
                <div class="add-btn">
                    <a href="{{route('provider.provider-project.edit',['id'=>0 ,'provider_id' => $provider_id ?? 0])}}"
                       class="button">+ 添加历史项目</a>
                </div>
            </div>
            <div class="table-box">

                <table class="table" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th width="20%">项目名称</th>
                        <th width="20%">开发商名称</th>
                        <th width="20%">合同签订时间</th>
                        <th width="10%">所在城市</th>
                        <th width="20%">创建时间</th>
                        <th width="10%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $key => $item)
                        <tr>
                            <td>{{ $item['name'] or '' }}</td>
                            <td>{{ $item['developer_name'] or '' }}</td>
                            <td>{{ $item['time'] or '' }}</td>
                            <td>{{ $item['province']['name'] or ''}} {{ $item['city']['name'] or '' }}</td>
                            <td>{{ $item['created_at'] or '' }}</td>
                            <td>
                                <a title="编辑" class="icon-edit"
                                   href="{{route('provider.provider-project.edit',['id'=>$item['id'] ?? 0 ,'provider_id' =>$item['provider_id'] ?? 0])}}">
                                    <i class="iconfont">&#xe626;</i>
                                </a>
                                <a title="删除" class="delete" data-id="{{ $item['id'] or '' }}">
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