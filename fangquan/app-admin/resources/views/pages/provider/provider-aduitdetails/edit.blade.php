<?php
ufa()->extCss([
        'provider/provider-aduitdetails/edit'
]);
ufa()->extJs([
        '../lib/jquery-form-validator/jquery.form-validator',
        '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
        '../lib/jquery-file-upload/js/jquery.fileupload',
        'provider/provider-aduitdetails/edit'
]);

ufa()->addParam(
        [
                'id'          => $id ?? 0,
                'provider_id' => $provider_id ?? 0,
        ]
);
?>


@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        @include('partials.provider.nav', ['provider_id' =>$provider_id ?? 0])
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">验厂报告添加</p>
                @else
                    <p class="top-title">验厂报告编辑</p>
                @endif
            </div>
            <form id="form" onsubmit="return false">

                <aside>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">验厂报告名称：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="name" value="{{$name or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请添加验厂报告名称"/>
                        </div>
                    </div>


                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label for="right-label" class="text-right">验厂报告类型：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="type" class="options"
                                    data-validation="required length"
                                    data-validation-length="max50"
                                    data-validation-error-msg="请选择证书名称">
                                <option value="">--请选择验厂报告类型--</option>
                                @foreach($provider_aduitdetails_types as $key => $name)
                                    <option @if($key == ($type ?? 0)) selected
                                            @endif value="{{$key}}">{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label for="right-label" class="text-right">文件名：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="filename" value="{{$filename or ''}}"
                                   class="file-name"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请添加文件名"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">选择文件：</label>
                        </div>
                        <div class="small-14 columns">
                            <div class="img-box">
                                @include('common.add-picture', [
                                        'single' => true,
                                        'tips' => '上传文件',
                                        'name' => 'link',
                                        'images' => $images ?? [],
                                   ])
                                <p class="error-file error-tip" style="display: none;">请上传文件</p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <input type="hidden" name="id" value="{{$id ?? 0}}">
                        <input type="hidden" name="provider_id" value="{{$provider_id ?? 0}}">
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