<?php
ufa()->extCss([
    'brand/brand-factory/index'
]);
ufa()->extJs([
    'brand/brand-factory/index',
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        @include('common.brand-nav',['brand_id'=>$brand_id ?? 0])
        <div class="content-box">
            @include('common.press',['brand_id'=> $provider_id ?? 0])
            <div class="button-box">
                <div class="add-btn">
                    <a href="{{route('brand.brand-factory.edit',['id'=>$id ?? 0, 'brand_id' => $brand_id ?? 0])}}">新增厂家管理</a>
                </div>
            </div>

            <table class="table" cellspacing="0" cellpadding="0">
                <thead>
                <tr>
                    <th width="20%">类型</th>
                    <th width="20%">生产面积</th>
                    <th width="20%">单位</th>
                    <th width="30%">经营地址</th>
                    <th width="10%">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach(($items ?? []) as $item)
                <tr>
                    <td>{{$item['factory_type_name'] or ''}}</td>
                    <td>{{$item['production_area'] or ''}}</td>
                    <td>{{$item['unit'] or ''}}</td>
                    <td>{{$item['province_name'] or ''}}{{$item['city_name'] or ''}}</td>
                    <td>
                        <a class="icon-edit" title="编辑" href="{{route('brand.brand-factory.edit',['id'=>$item['id'], 'brand_id' => $item['brand_id']])}}">
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