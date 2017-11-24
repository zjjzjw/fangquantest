<?php
ufa()->extCss([
        'role/role/index'
]);
ufa()->extJs([
        'role/role/index',
]);
?>
@extends('layouts.master')
@section('master.content')

    <div class="wrapper-box">
    <div id="contain">
        <div class="filter-box">
            <div class="add">
                <a href="{{route('role.role.edit',['id'=>0])}}" class="button add-btn">+角色</a>
            </div>
        </div>

        <div class="table-box">
            <table class="table" cellspacing="0" cellpadding="0">
                <thead>
                <tr>
                    <th width="10%">编号</th>
                    <th width="30%">角色名称</th>
                    <th width="30%">角色权限</th>
                    <th width="10%">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{$item['id']}}</td>
                        <td>{{$item['name']}}</td>
                        <td>{{$item['permission_names']}}</td>
                        <td>
                            <a class="icon-edit" title="编辑" href="{{route('role.role.edit',['id'=>$item['id']])}}">
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
    </div>
    </div>
    {{--分页--}}
    @if(!$paginate->isEmpty())
        <div class="patials-paging">
            {!! $paginate->render() !!}
        </div>
    @endif
    @include('common.prompt-pop',['type'=>1])
    @include('common.confirm-pop' ,['type' => 2,'confirm_text' => "这条数据"])
@endsection