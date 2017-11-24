<?php
ufa()->extCss([
    'content-publish/category/index'
]);
ufa()->extJs([
    'content-publish/category/index',
]);
?>
@extends('layouts.master')
@section('master.content')

    <div class="wrapper-box">
        <div id="contain">
            <div class="add-div">
                <a href="{{route('content-publish.category.edit', ['parent_id'=>0, 'id' => 0])}}"
                   class="button">+创建分类</a>
            </div>
            <div class="table-box">
                <div class="title-box">
                    <span style="width:69%;">分类名称</span>
                    <span style="width:10%;">状态</span>
                    <span style="width:20%;">操作</span>
                </div>
                <div class="content-box">
                    <ul>
                        @foreach($items ?? [] as $key => $item)
                        <li data-item="">
                            <p class="category-name"><span class="left-icon to-all" data-id="{{$item['id']}}">+</span>{{$item['name']}}</p>
                            <p class="state">{{$item['status_name']}}</p>
                            <div class="action">
                                <a class="first-edit" href="{{route('content-publish.category.edit',
                                    [
                                        'id' =>$item['id'],
                                        'parent_id' => $item['parent_id']
                                    ]
                                    )}}">编辑</a>
                                <a class="add" href="{{route('content-publish.category.edit',
                                    [
                                        'id' =>0,
                                        'parent_id' => $item['id']
                                    ]
                                    )}}" data-id="id">添加</a>
                                <a class="delete" data-id="{{$item['id']}}">删除</a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @include('common.prompt-pop',['type'=>1])
    @include('common.confirm-pop' ,['type' => 2,'confirm_text' => "这条数据"])

    <script type="text/html" id="categoryTpl">
        <ul style="padding-left:1%;">
            <% for ( var i = 0; i < result.length; i++ ) { %>
            <li data-item="<%=result[i].id%>">
            <p class="category-name"><span class="left-icon to-all" data-id="<%=result[i].id%>">+</span><%=result[i].name%></p>
            <p class="state-model"><%=result[i].status_name%></p>
            <div class="action-model">
                <a class="edit" href="/content-publish/<%=result[i].parent_id%>/category/edit/<%=result[i].id%>"  data-id="<%=result[i].id%>" data-parent-id="<%=result[i].parent_id%>">编辑</a>
                <a class="add" href="/content-publish/<%=result[i].id%>/category/edit/0"  data-id="<%=result[i].id%>" data-parent-id="<%=result[i].parent_id%>">添加</a>
                <a class="delete" data-id="<%=result[i].id%>">删除</a>
            </div>
        </li>
    <% } %>
    </ul>
</script>
@endsection