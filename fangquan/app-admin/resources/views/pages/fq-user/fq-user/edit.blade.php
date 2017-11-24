<?php
ufa()->extCss([
    '../lib/datetimepicker/jquery.datetimepicker',
    'fq-user/fq-user/edit'
]);
ufa()->extJs([
    '../lib/jquery-form-validator/jquery.form-validator',
    'fq-user/fq-user/edit',
]);
ufa()->addParam(['id' => $id ?? 0,]);
?>

@extends('layouts.master') @section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">账号添加</p>
                @else
                    <p class="top-title">账号编辑</p>
                @endif
            </div>

            <form id="form" onsubmit="return false">
                <aside>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">账号：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="account" value="{{ $account or '' }}"
                                   data-validation="required length"
                                   data-validation-length="max50" data-validation-error-msg="请输入账号">
                        </div>
                    </div>
                    @if(!empty($id))
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">手机号：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="mobile" value="{{ $mobile or '' }}">
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">账号类型：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="account_type" data-validation="required" data-validation-error-msg="请选择账号类型">
                                <option value="">--请选择--</option>

                                @foreach($account_type_enums as $account_type_key => $account_type_item)
                                    <option @if($account_type_key == ($account_type ?? 0)) selected
                                            @endif value="{{ $account_type_key }}">{{ $account_type_item }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">区域权限：</label>
                        </div>
                        <div class="small-14 columns" style="padding-top: 20px">

                            @foreach($project_area_enums as $project_area_key => $project_area_item)
                                <div class="power">
                                    <input name="project_area[]" id="project_area{{ $project_area_key or 0 }}"
                                           type="checkbox" value="{{ $project_area_key or 0 }}"
                                           @if(in_array($project_area_key,($project_area_array ?? []))) checked="checked" @endif
                                    />
                                    <label for="project_area{{ $project_area_key }}">{{ $project_area_item }}</label>
                                </div>
                            @endforeach

                            <p class="error-tip-power error-tip" style="display: none;">请选择至少1个区域权限</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">项目类别权限：</label>
                        </div>
                        <div class="small-14 columns" style="padding-top: 20px">

                            @foreach(($project_category_enums ?? []) as $project_category_key => $project_category_item)
                                <div class="power">
                                    <input name="project_category[]"
                                           id="project_category{{ $project_category_key or 0 }}"
                                           type="checkbox" value="{{ $project_category_key or 0 }}"
                                           @if(in_array($project_category_key,($project_category_array ?? []))) checked="checked" @endif
                                    />
                                    <label for="project_category{{ $project_category_key or 0 }}">{{ $project_category_item or '' }}</label>
                                </div>
                            @endforeach

                            <p class="error-tip-power error-tip" style="display: none;">请选择至少1个项目类别权限限</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">到期时间：</label>
                        </div>
                        <div class="small-14 columns">

                            <input name="expire" type="text" class="date" value="{{ $expire or '' }}"
                                   data-validation="required"

                            data-validation-error-msg="请选择到期时间"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">使用状态：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="status" data-validation="required" data-validation-error-msg="请选择使用状态">
                                <option value="">--请选择--</option>

                                @foreach($status_type_enums as $status_type_key => $status_type_item)
                                    <option @if($status_type_key == ($status ?? 0)) selected
                                            @endif value="{{ $status_type_key }}">{{ $status_type_item }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                </aside>

                <div class="text-center">
                    <input type="hidden" name="id" value="{{$id ?? 0}}">
                    <input type="hidden" name="role_id" value="{{$role_id ?? 0}}">
                    <input type="submit" class="button save" value="保存">
                    <a class="button clone" href="javascript:history.back()">取消</a>
                </div>
            </form>
        </div>
    </div>
    @include('common.success-pop') @include('common.loading-pop') @include('common.prompt-pop',['type'=>1]) @endsection
