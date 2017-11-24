<?php
ufa()->extCss([
        'category/index'
]);
ufa()->extJs([
        'category/index',
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                <div class="add-btn">
                    <a href="{{route('category.category.edit',['id'=>0,'parent_id' => 0])}}">新增品类</a>
                </div>
            </div>

            <div class="table-box">
                <div class="title">
                    <span class="special-span" style="width: 61%;">品类</span>
                    <span style="width: 26%;">排序</span>
                    <span style="width: 10%;">操作</span>
                </div>
                <div class="content-box">
                    <ul class="parent-box">

                        @foreach($items as $key => $item)
                            <li>
                                <div class="left-box">
                                    <a href="javascript:void(0);" class="status"><i class="iconfont file">
                                            &#xe613;</i></a>
                                    <label><i class="iconfont file">&#xe753;</i>{{ $item['name'] or '' }}
                                        @if(!empty($item['price']))
                                            ({{ $item['price'] or '' }})
                                        @endif
                                    </label>
                                </div>
                                <div class="right-box">
                                    <span class="sort">{{$item['order'] or 0}}</span>
                                    <div class="action">
                                        <a title="编辑" class="icon-edit"
                                           href="{{route('category.category.edit',['id' => $item['id'],'parent_id' => $item['parent_id']])}}">
                                            <i class="iconfont">&#xe626;</i>
                                        </a>
                                        <a title="添加子品类" class="icon-add"
                                           href="{{route('category.category.edit',['id' => 0,'parent_id' => $item['id']])}}">
                                            <i class="iconfont">&#xe602;</i>
                                        </a>
                                    </div>
                                </div>
                                <ul class="second-level" style="display: block;">

                                    @foreach($item['nodes'] ?? [] as $node)
                                        <li>
                                            <div class="left-box">
                                                <a href="javascript:void(0);" class="status">
                                                    <i class="iconfont file">&#xe613;</i>
                                                </a>
                                                <label>
                                                    <i class="iconfont file">&#xe753;</i>
                                                    {{ $node['name'] or '' }}
                                                    @if(!empty($node['price']))
                                                        ({{ $node['price'] or '' }})
                                                    @endif
                                                </label>
                                            </div>
                                            <div class="right-box">
                                                <span class="sort">{{ $node['order'] or 0 }}</span>
                                                <div class="action">
                                                    <a title="编辑" class="icon-edit"
                                                       href="{{route('category.category.edit',['id' => $node['id'],'parent_id' => $node['parent_id']])}}">
                                                        <i class="iconfont">&#xe626;</i>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection