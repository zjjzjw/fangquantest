<?php
ufa()->extCss([
    'brand/custom-product/index',
]);
ufa()->extJs([
    'brand/custom-product/index',
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        @include('common.brand-nav',['id' => $brand_id ?? 0])
        <div class="content-box">
            @include('common.press',['brand_id'=> $provider_id ?? 0])
            <div class="button-box">
                <div class="add-btn">
                    <a href="{{route('brand.custom-product.edit',['brand_id' => $brand_id, 'id'=>0])}}">新增定制化产品、服务</a>
                </div>
            </div>

            <table class="table" cellspacing="0" cellpadding="0">
                <thead>
                <tr>
                    <th width="20%">序号</th>
                    <th width="20%">开发商名称</th>
                    <th width="30%">定制产品名称</th>
                    <th width="20%">所用项目楼盘名称</th>
                    <th width="10%">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach( ($items ?? []) as $item )
                    <tr>
                        <td>{{$item['id']}}</td>
                        <td>{{$item['developer_name'] or ''}}</td>
                        <td>{{$item['product_name'] or ''}}</td>
                        <td>{{$item['loupan_name'] or ''}}</td>
                        <td>
                            <a class="icon-edit" title="编辑"
                               href="{{route('brand.custom-product.edit',['brand_id' => $brand_id, 'id'=>$item['id']])}}">
                                <i class="iconfont">&#xe626;</i>
                            </a>
                            <a data-id="{{$item['id']}}" title="删除" class="delete">
                                <i class="iconfont">&#xe601;</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
            {{--{{分页}}--}}
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