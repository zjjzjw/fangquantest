<?php
ufa()->extCss([
    'developer/developer-project-contact/edit'
]);
ufa()->extJs([
    '../lib/jquery-form-validator/jquery.form-validator',
    'developer/developer-project-contact/edit'
]);

ufa()->addParam(['id' => $id ?? 0,'developer_project_id' => $project_id ?? 0]);
?>

@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">开发商添加</p>
                @else
                    <p class="top-title">开发商编辑</p>
                @endif
            </div>
            <form id="form" onsubmit="return false">

                <aside>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">联系人类型：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="type"
                                    data-validation="required"
                                    data-validation-error-msg="请选择联系人类型">
                                <option value="">--请选择--</option>
                                @foreach($developer_project_contact_type as $key => $name)
                                <option value="{{$key}}"
                                    @if(($type ?? 0) == $key) selected @endif
                                >{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">公司名称：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="company_name" value="{{$company_name or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入公司名称"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">联系人：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="contact_name" value="{{$contact_name or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入联系人"/>
                        </div>
                    </div>


                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">手机号：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="mobile" value="{{$mobile or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max11"
                                   data-validation-error-msg="请输入手机号"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">职务：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="job" value="{{$job or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入职务"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">联系地址：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="address" value="{{$address or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入联系地址"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">备注：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="remark" value="{{$remark or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入备注"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">排序：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="sort" value="{{$sort or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入排序"/>
                        </div>
                    </div>


                    <div class="text-center">
                        <input type="hidden" name="id" value="{{$id ?? 0}}">
                        <input type="hidden" name="developer_project_id" value="{{$project_id ?? 0}}">
                        <input type="submit" class="button small-width save" value="保存">
                        <a class="button small-width clone" href="JavaScript:history.back();">返回</a>
                    </div>
                </aside>
            </form>
        </div>
    </div>
    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.prompt-pop',['type'=>1])
@endsection