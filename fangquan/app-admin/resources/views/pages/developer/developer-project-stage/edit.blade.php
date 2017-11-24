<?php
ufa()->extCss([
    '../lib/datetimepicker/jquery.datetimepicker',
        'developer/developer-project-stage/edit'
]);
ufa()->extJs([
        '../lib/datetimepicker/jquery.datetimepicker',
        '../lib/jquery-form-validator/jquery.form-validator',
        '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
        'developer/developer-project-stage/edit'
]);

ufa()->addParam(
    [
        'id' => $id ?? 0,
        'project_id' => $project_id ?? 0,
    ]
);
?>




@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">项目阶段时间添加</p>
                @else
                    <p class="top-title">项目阶段时间编辑</p>
                @endif
            </div>
            <form id="form" onsubmit="return false">

                <aside>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">项目阶段：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="stage_type"
                                    data-validation="required"
                                    data-validation-error-msg="请选择项目阶段">
                                <option value="">--请选择--</option>
                                @foreach(($developer_project_stage_list ?? []) as $value)
                                    <option value="{{$value['id']}}"
                                            @if(($stage_type ?? 0) == $value['id']) selected @endif
                                    >{{$value['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">阶段时间：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="time" value="{{$time or ''}}" class="time"
                                   data-validation="required"
                                   data-validation-error-msg="请输入阶段时间"/>
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="hidden" name="id" value="{{$id ?? 0}}">
                        <input type="hidden" name="project_id" value="{{$project_id ?? 0}}">
                        <input type="submit" class="button small-width save" value="保存">
                        <a class="button small-width clone" href="JavaScript:history.back();">返回</a>
                    </div>
                </aside>
            </form>
        </div>
    </div>
    @include('common.add-picture-item')
    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.prompt-pop',['type'=>1])
@endsection