<?php
ufa()->extCss([
        'developer/developer-project-stage/index'
]);
ufa()->extJs([
        'developer/developer-project-stage/index',
]);
?>
@extends('layouts.master')
@section('master.content')

    <div class="wrapper-box">
        <div class="filter-box">
            <div class="add">
                <a href="{{route('developer.developer-project-stage-time.edit',['id'=>0, 'project_id' => $project_id])}}"
                   class="button add-btn">+项目阶段时间</a>
            </div>
        </div>

        <div class="table-box">
            <table class="table" cellspacing="0" cellpadding="0">
                <thead>
                <tr>
                    <th width="5%">编号</th>
                    <th width="20%">阶段名称</th>
                    <th width="20%">阶段时间</th>
                    <th width="20%">创建时间</th>
                    <th width="10%">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{$item['id'] or 0}}</td>
                        <td>{{$item['stage_name'] or ''}}</td>
                        <td>{{$item['time'] or ''}}</td>
                        <td>{{$item['created_at'] or ''}}</td>
                        <td>
                            <a class="icon-edit" title="编辑"
                               href="{{route('developer.developer-project-stage-time.edit',['id'=>$item['id'], 'project_id' => $item['project_id']])}}">
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
                {!! $paginate->render() !!}
            </div>
        @endif
    </div>

    @include('common.prompt-pop',['type'=>1])
    @include('common.confirm-pop' ,['type' => 2,'confirm_text' => "这条数据"])
@endsection