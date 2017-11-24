<?php
ufa()->extCss([
        'product/product-category/index'
]);
ufa()->extJs([
        'product/product-category/index',
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
    <div id="contain">
        <div class="filter-box">
            <div class="add">
                <a href="{{route('product.product-category.edit',['level'=> 1,'id'=> 0,'parent_id'=> 0])}}"
                   class="button add-btn">添加品类</a>
            </div>
        </div>
        <div class="table-box">
            <div class="title">
                <span style="width: 30%;">品类名称</span>
                <span style="width: 10%;">状态</span>
                <span style="width: 10%;">排序</span>
                <span style="width: 30%; text-align: center;">描述</span>
                <span style="width: 10%;">操作</span>
            </div>
            <div class="content-box">
                <ul class="parent-box">

                    @foreach($items as $key => $item)
                        <li>
                            <div class="left-box">
                                <a href="javascript:void(0);" class="status"><i class="iconfont file">&#xe613;</i></a>
                                <label><i class="iconfont file">&#xe753;</i>{{ $item['name'] or '' }}</label>
                            </div>
                            <div class="right-box">
                                <span class="if-show">{{ $item['status_name'] or '' }}</span>
                                <span class="sort">{{ $item['sort'] or '' }}</span>
                                <span class="discrib">{{ $item['description'] or '' }}</span>
                                <div class="action">
                                    <a title="编辑" class="icon-edit"
                                       href="{{route('product.product-category.edit',['level'=>$item['level'] ?? 1,'id'=>$item['id'] ?? 0,'parent_id' =>$item['parent_id'] ?? 0])}}">
                                        <i class="iconfont">&#xe626;</i>
                                    </a>

                                    <a title="添加子品类" class="icon-add"
                                       href="{{route('product.product-category.edit',[
                                            'level'=> $item['level']+1 ?? 0, 'id'=> 0, 'parent_id'=> $item['id'] ?? 0
                                       ])}}">

                                        <i class="iconfont">&#xe602;</i>
                                    </a>

                                </div>
                            </div>
                            <ul class="second-level" style="display: block;">

                                @foreach($item['results'] ?? [] as $second_item)
                                    <li>
                                        <div class="left-box">
                                            <a href="javascript:void(0);" class="status"><i
                                                        class="iconfont file">&#xe613;</i></a>
                                            <label><i class="iconfont file">&#xe753;</i>{{ $second_item['name'] or '' }}
                                            </label>
                                        </div>
                                        <div class="right-box">
                                            <span class="if-show">{{ $second_item['status_name'] or '' }}</span>
                                            <span class="sort">{{ $second_item['sort'] or '' }}</span>
                                            <span class="discrib">{{ $second_item['description'] or '' }}</span>
                                            <div class="action">
                                                <a title="编辑" class="icon-edit"
                                                   href="{{route('product.product-category.edit',['level'=>$second_item['level'] ?? 0,'id'=>$second_item['id'] ?? 0,'parent_id' =>$second_item['parent_id'] ?? 0])}}">
                                                    <i class="iconfont">&#xe626;</i>
                                                </a>

                                                <a title="添加子品类" class="icon-add"
                                                   href="{{ route('product.product-category.edit',[
                                                        'level'=> $second_item['level']+1 ?? 0, 'id'=> 0, 'parent_id'=> $second_item['id'] ?? 0
                                                   ]) }}">
                                                    <i class="iconfont">&#xe602;</i>
                                                </a>

                                            </div>
                                        </div>
                                        <ul class="third-level" style="display: block;">
                                            @foreach($second_item['results'] ?? [] as  $three_item)
                                                <li>
                                                    <div class="left-box">
                                                        <label><i class="iconfont file">
                                                                &#xe605;</i>{{ $three_item['name']  or '' }}
                                                        </label>
                                                    </div>
                                                    <div class="right-box">
                                                        <span class="if-show">{{ $three_item['status_name']  or '' }}</span>
                                                        <span class="sort">{{ $three_item['sort']  or '' }}</span>
                                                        <span class="discrib">{{ $three_item['description']  or '' }}</span>
                                                        <div class="action">
                                                            <a title="编辑" class="icon-edit"
                                                               href="{{route('product.product-category.edit',['level'=> $three_item['level'] ?? 0,'id'=> $three_item['id'] ?? 0,'parent_id'=> $three_item['id']] ?? 0)}}">
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
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
        <input type="hidden" id="organization_ids" value="" name="organization_ids"/>
    </div>
    </div>
    @include('common.prompt-pop',['type'=>1])
    @include('common.confirm-pop' ,['type' => 2])
@endsection