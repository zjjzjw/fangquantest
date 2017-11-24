<?php
ufa()->extCss([
    'product/index'
]);
ufa()->extJs([
    'product/index',
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                <div class="add-btn">
                    <a href="{{route('product.edit',['id'=>0])}}">新增产品</a>
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
                        <div class="article-id small-8 columns">
                            <div class="small-4 columns text-left">
                                <label for="right-label" class="text-left">品类：</label>
                            </div>
                            <div class="small-20 columns">
                                <input class="choose-type" type="text" placeholder="请选择品类" readonly="readonly"
                                       value="{{$appends['product_category_name'] or ''}}"
                                       data-validation="required"
                                       data-validation-error-msg="请选择品类">
                                <input type="hidden" id="choose_type" name="product_category_id"
                                       value="{{$appends['product_category_id'] or 0}}">
                            </div>
                            <div class="choose-type-box" style="display: none;">
                                <ul>
                                    @foreach(($category_lists ?? []) as $category)
                                        <li class="first-wrap">
                                            <span>{{$category['name']}}</span>
                                            <ul style="
                                            @if(in_array(($appends['product_category_id'] ?? 0),$category['node_ids']))
                                                    display: block;
                                            @else
                                                    display: none;
                                            @endif
                                                    ">
                                                @foreach(($category['nodes'] ?? []) as $node)
                                                    <li>
                                                        <input id="radio{{$node['id']}}" type="radio" name="category_type"
                                                               data-type-id="{{$node['id']}}"
                                                               value="{{$node['name']}}"
                                                               @if(($appends['product_category_id'] ?? 0) == $node['id']) checked @endif
                                                        >
                                                        <label for="radio{{$node['id']}}">{{$node['name']}}</label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
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
                            <a href="{{route('product.index')}}" class="button reset-btn">重置</a>
                        </div>
                    </div>
                </form>
            </div>

            <table class="table" cellspacing="0" cellpadding="0">
                <thead>
                <tr>
                    <th width="30%">公司名称</th>
                    <th width="20%">缩略图</th>
                    <th width="20%">品类</th>
                    <th width="10%">品牌</th>
                    <th width="10%">型号</th>
                    <th width="10%">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach(($items ?? []) as $item)
                    <tr>
                        <td>{{$item['company_name'] or ''}}</td>
                        <td><img src="{{$item['logo_url'] or ''}}?imageView2/2/w/150/h/100" alt=""></td>
                        <td>{{$item['product_category_name'] or ''}}</td>
                        <td>{{$item['brand_name'] or ''}}</td>
                        <td>{{$item['product_model'] or ''}}</td>
                        <td>
                            <a class="icon-edit" title="编辑" href="{{route('product.edit',['id'=>$item['id']])}}">
                                <i class="iconfont">&#xe626;</i>
                            </a>
                            <a data-id="{{$item['id']}}" title="删除" class="delete">
                                <i class="iconfont">&#xe601;</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
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