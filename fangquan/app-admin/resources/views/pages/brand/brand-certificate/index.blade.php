<?php
ufa()->extCss([
    'brand/brand-certificate/index'
]);
ufa()->extJs([
    'brand/brand-certificate/index',
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
                    <a href="{{route('brand.brand-certificate.edit',['id'=>$id ?? 0, 'brand_id'=> $brand_id ?? 0])}}">新增认证证书</a>
                </div>
            </div>

            <div class="search-box">

                @if (count($errors) > 0)
                    <p class="error-alert">
                        @foreach ($errors->all() as $key => $error)
                            {{$key + 1}}、 {{ $error }}
                        @endforeach
                    </p>
                @endif

                <form method="GET">
                    <div class="row top-box">
                        <div class="small-8 columns">
                            <div class="small-8 columns text-right">
                                <label for="right-label" class="text-right">关键字：</label>
                            </div>
                            <div class="small-14 columns">
                                <input type="text" name="keyword" value="{{$appends['keyword'] or ''}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="columns">
                            <input type="submit" class="btn" value="搜索"/>
                            <a href="{{route('brand.brand-certificate.index',['brand_id' => $brand_id])}}" class="button reset-btn">重置</a>
                        </div>
                    </div>
                </form>
            </div>

            <table class="table" cellspacing="0" cellpadding="0">
                <thead>
                <tr>
                    <th width="40%">证书名称</th>
                    <th width="50%">证书类型</th>
                    <th width="10%">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach(($items ?? []) as $item)
                <tr>
                    <td>{{$item['name'] or ''}}</td>
                    <td>{{$item['type_name'] or ''}}</td>
                    <td>
                        <a class="icon-edit" title="编辑" href="{{route('brand.brand-certificate.edit',['id'=>$item['id'], 'brand_id' => $item['brand_id']])}}">
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