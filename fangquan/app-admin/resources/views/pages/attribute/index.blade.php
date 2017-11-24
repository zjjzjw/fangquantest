<?php
ufa()->extCss([
        'attribute/index'
]);
ufa()->extJs([
        'attribute/index',
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                <div class="add-btn">
                    <a href="{{route('category.attribute.edit',['id'=>0])}}">新增属性</a>
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
                                       value="{{$appends['category_type'] or ''}}"
                                       data-validation="required"
                                       data-validation-error-msg="请选择品类">
                                <input type="hidden" id="choose_type" name="category_id"
                                       value="{{$appends['category_id'] or 0}}">
                            </div>
                            <div class="choose-type-box" style="display: none;">
                                <ul>
                                    @foreach(($category_lists ?? []) as $key=>$category)
                                        <li class="first-wrap" data-choose="{{$key}}">
                                            <span>{{$category['name']}}</span>

                                        </li>
                                    @endforeach
                                </ul>
                                @foreach(($category_lists ?? []) as $p=>$category)
                                        <ul class="node-box" data-node="{{$p}}" style="
                                        @if(in_array(($appends['category_id'] ?? 0),$category['node_ids']))
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
                                                           @if(($appends['category_id'] ?? 0) == $node['id']) checked @endif
                                                    >
                                                    <label for="radio{{$node['id']}}">{{$node['name']}}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                @endforeach
                            </div>
                        </div>
                        <div class="small-8 columns">
                            <div class="small-8 columns text-right">
                                <label for="right-label" class="text-right">关键字：</label>
                            </div>
                            <div class="small-14 columns">
                                <input type="text" name="keyword" value="{{$appends['keyword'] or ''}}" placeholder="请输入属性关键字">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="columns">
                            <input type="submit" class="btn" value="搜索"/>
                            <a href="{{route('category.attribute.index')}}" class="button reset-btn">重置</a>
                        </div>
                    </div>
                </form>
            </div>

            <table class="table" cellspacing="0" cellpadding="0">
                <thead>
                <tr>
                    <th width="30%">分类名称</th>
                    <th width="30%">属性</th>
                    <th width="30%">排序</th>
                    <th width="30%">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach(($items ?? []) as $item)
                    <tr>
                        <td>{{$item['category_name'] or ''}}</td>
                        <td>{{$item['name'] or ''}}</td>
                        <td>{{$item['order'] or 0}}</td>
                        <td>
                            <a class="icon-edit" title="编辑"
                               href="{{route('category.attribute.edit',['id'=>$item['id']])}}">
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