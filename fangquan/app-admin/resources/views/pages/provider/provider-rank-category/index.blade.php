<?php
ufa()->extCss([
    '../lib/autocomplete/autocomplete',
    'provider/provider-rank-category/index'
]);
ufa()->extJs([
    '../lib/autocomplete/autocomplete',
    'provider/provider-rank-category/index',
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">

            <div class="search-box">

                <form method="GET" action="" id="" onsubmit="return false">
                    <div class="row">
                        <div class="small-8 columns">
                            <div class="small-8 columns text-right">
                                <label for="right-label" class="text-right">公司名称：</label>
                            </div>
                            <div class="small-14 columns">
                                <input type="text" id="keyword" name="company_name"
                                       value="{{$appends['company_name'] or ''}}"
                                       data-provider_id="{{$appends['provider_id'] or ''}}">
                                <div class="content-wrap"></div>
                            </div>
                        </div>

                        <div class="small-8 columns">
                            <div class="small-8 columns text-right">
                                <label for="right-label" class="text-right">品类：</label>
                            </div>
                            <div class="small-14 columns">
                                <select name="category_id">
                                    <option value="">--请选择品类--</option>
                                    @foreach(($product_category ?? []) as $category)
                                        <option value="{{$category['id']}}"
                                                @if(($appends['category_id'] ?? 0) == $category['id']) selected @endif
                                        >{{$category['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="columns">
                            <input type="submit" class="btn" value="搜索"/>
                            <a href="{{route('provider.provider-rank-category.index')}}" class="button reset-btn">重置</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="filter-box">
                <div class="add">
                    <a href="{{route('provider.provider-rank-category.edit',['id'=>0])}}" class="button add-btn">+排名</a>
                </div>
            </div>
            <div class="table-box">

                <table class="table" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th width="10%">编号</th>
                        <th width="20%">品类名称</th>
                        <th width="20%">公司名称</th>
                        <th width="10%">排名</th>
                        <th width="20%">创建时间</th>
                        <th width="10%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(($items ?? [] ) as $item)
                    <tr>
                        <td>{{$item['id'] or ''}}</td>
                        <td>{{$item['category_name'] or ''}}</td>
                        <td>{{$item['provider_name'] or ''}}</td>
                        <td>{{$item['rank'] or ''}}</td>
                        <td>{{$item['created_at'] or ''}}</td>
                        <td>
                            <a class="icon-edit" title="编辑" href="{{route('provider.provider-rank-category.edit',['id'=>$item['id']])}}">
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
    @include('common.confirm-pop' ,['type' => 2,'confirm_text' => "这条数据"])
@endsection