<?php
ufa()->extCss([
        '/developer/developer-project-contact/index'
]);
ufa()->extJs([
        '/developer/developer-project-contact/index',
]);
?>
@extends('layouts.master')
@section('master.content')

    <div class="wrapper-box">
        <div class="filter-box">
            <div class="add">
                <a href="{{route('developer.developer-project-contact.edit',['id'=>0,'project_id' => $project_id ?? 0])}}"
                   class="button add-btn">+ 联系人</a>
            </div>
        </div>

        <div class="table-box">
            <table class="table" cellspacing="0" cellpadding="0">
                <thead>
                <tr>
                    <th width="10%">联系人类型</th>
                    <th width="20%">公司名称</th>
                    <th width="10%">联系人名称</th>
                    <th width="10%">联系电话</th>
                    <th width="10%">联系人职务</th>
                    <th width="10%">地址</th>
                    <th width="10%">备注</th>
                    <th width="10%">创建时间</th>
                    <th width="10%">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{$item['type_name'] or ''}}</td>
                        <td>{{$item['company_name'] or ''}}</td>
                        <td>{{$item['contact_name'] or ''}}</td>
                        <td>{{$item['mobile'] or ''}}</td>
                        <td>{{$item['job'] or ''}}</td>
                        <td>{{$item['address'] or ''}}</td>
                        <td>{{$item['remark'] or ''}}</td>
                        <td>{{$item['created_at'] or ''}}</td>
                        <td>
                            <a class="icon-edit" title="编辑"
                               href="{{route('developer.developer-project-contact.edit',['id'=>$item['id'] ,'project_id' => $item['developer_project_id'] ?? 0])}}">
                                <i class="iconfont">&#xe626;</i>
                            </a>
                            <a data-id="{{$item['id'] or 0}}" title="删除" class="delete">
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
                {!! $paginate->render() !!}
            </div>
        @endif
    </div>
    @include('common.prompt-pop',['type'=>1])
    @include('common.confirm-pop' ,['type' => 2,'confirm_text' => "这条数据"])
@endsection