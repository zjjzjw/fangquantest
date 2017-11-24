<?php
ufa()->extCss([
        'provider/provider-service-network/index'
]);
ufa()->extJs([
        'provider/provider-service-network/index',
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        @include('partials.provider.nav',['provider_id'=>$provider_id ?? 0])
        <div class="content-box">

            <div class="button-box">
                <div class="add-btn">
                    <a href="{{route('provider.provider-service-network.edit',['id'=>0 ,'provider_id' => $provider_id ?? 0])}}"
                       class="button">+ 添加网点</a>
                </div>
            </div>

            <div class="table-box">
                <table class="table" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th width="20%">网点名称</th>
                        <th width="30%">地址</th>
                        <th width="5%">员工数量</th>
                        <th width="10%">联系人</th>
                        <th width="20%">联系电话</th>
                        <th width="10%">创建时间</th>
                        <th width="5%">操作</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($items as $key=>$item)
                        <tr>
                            <td>{{$item['name'] or ''}}</td>
                            <td>{{$item['province']['name'] or ''}} {{$item['city']['name'] or ''}} {{$item['address'] or ''}}</td>
                            <td>{{$item['worker_count'] or ''}}</td>
                            <td>{{$item['contact'] or ''}}</td>
                            <td>{{$item['telphone'] or ''}}</td>
                            <td>{{$item['created_at'] or ''}}</td>
                            <td>
                                <a title="编辑" class="icon-edit"
                                   href="{{route('provider.provider-service-network.edit',['id'=>$item['id'] ?? 0 ,'provider_id' =>$item['provider_id'] ?? 0])}}">
                                    <i class="iconfont">&#xe626;</i>
                                </a>
                                <a title="删除" class="delete" data-id="{{$item['id'] or 0}}">
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