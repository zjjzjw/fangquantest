<?php
ufa()->extCss([
    'developer/loupan/edit',
    '../lib/autocomplete/autocomplete',
]);
ufa()->extJs([
    '../lib/autocomplete/autocomplete',
    '../lib/jquery-form-validator/jquery.form-validator',
    '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
    'developer/loupan/edit'
]);

ufa()->addParam(
    [
        'id' => $id ?? 0,
        'developer_id' => $developer_id ?? 0,
        'areas' => $areas ?? [],
        'province_id' => $province_id ?? 0,
        'city_id' => $city_id ?? 0
    ]
);
?>


@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">楼盘名称添加</p>
                @else
                    <p class="top-title">楼盘名称编辑</p>
                @endif
            </div>
            <form id="form" onsubmit="return false">

                <aside>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">楼盘名称：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="name" value="{{$name or ''}}" placeholder="请输入楼盘名称"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请添加楼盘名称"/>

                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">地址：</label>
                        </div>
                        <div class="small-4 columns">
                            <select name="province_id" id="province_id" class="project_province"></select>
                        </div>
                        <div class="small-4 columns">
                            <select name="city_id" id="city_id" class="project_city"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">所属开发商：</label>
                        </div>
                        <div class="small-14 columns">
                            <div class="developer-group">
                                <?php $loupan_developers_i = 0;?>
                                @foreach((!empty($developer_info) ? $developer_info : ['']) as $loupan_developer)
                                    <div>
                                        <input type="text" value="{{$loupan_developer['name'] or ''}}" id="keyword"
                                               placeholder="请添加所属开发商，下拉联想项"
                                               class="developer"
                                               data-validation="required length"
                                               data-validation-length="max255"
                                               data-validation-error-msg="请添加所属开发商"/>
                                        @if($loupan_developers_i == 0)
                                            <a href="JavaScript:;" class="add-developer">&nbsp;&nbsp;&nbsp;&nbsp;+</a>
                                        @else
                                            <a href="JavaScript:;" class="close-developer">&nbsp;&nbsp;&nbsp;&nbsp;-</a>
                                        @endif
                                        <input id="developer_id" type="hidden" name="developer_ids[]"
                                               value="{{$loupan_developer['id'] or 0}}">
                                    </div>
                                        <?php $loupan_developers_i++; ?>
                                    @endforeach
                                    <div class="content-wrap"></div>
                            </div>
                        </div>
                        <p class="error-tip-brand error-tip" style="display: none;">请不要重复添加</p>
                    </div>
                </aside>
                <div class="text-center">
                    <input type="hidden" name="id" value="{{$id ?? 0}}">
                    <input type="submit" class="button small-width save" value="保存">
                    <a class="button small-width clone" href="JavaScript:history.back();">返回</a>
                </div>
            </form>
        </div>
    </div>
    <script type="text/html" id="developerTpl">
        <div>
            <input type="text"
                   class="developer"
                   placeholder="请添加所属开发商，下拉联想项"
                   data-validation="required length"
                   data-validation-length="max255"
                   data-validation-error-msg="请添加所属开发商"/>
            <a href="JavaScript:;" class="close-developer">&nbsp;&nbsp;&nbsp;&nbsp;-</a>
            <input id="developer_id" type="hidden" name="developer_ids[]" value=""/>
        </div>
    </script>
    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.prompt-pop',['type'=>1])
@endsection