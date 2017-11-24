<?php
ufa()->extCss([
    'brand/brand-certificate/edit'
]);
ufa()->extJs([
    '../lib/jquery-form-validator/jquery.form-validator',
    '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
    '../lib/jquery-file-upload/js/jquery.fileupload',
    'brand/brand-certificate/edit'
]);
ufa()->addParam([
    'id'       => $id ?? 0,
    'brand_id' => $brand_id ?? 0
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        @include('common.brand-nav',['brand_id'=>$brand_id ?? 0])
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">认证证书新增</p>
                @else
                    <p class="top-title">认证证书编辑</p>
                @endif
            </div>
            <form id="form" onsubmit="return false">
                <aside>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">证书名称：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="name" value="{{$name or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入证书名称"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">证书类型：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="type"
                                    data-validation="required"
                                    data-validation-error-msg="请选择属性">
                                <option value="">--选择类型--</option>
                                @foreach($brand_certificate_type as $key => $value)
                                    <option value="{{$key}}"
                                            @if(($type ?? 0) == $key) selected @endif
                                    >{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">证书附件：</label>
                        </div>
                        <div class="small-14 columns upload-img">
                            <div class="img-box">
                                @include('common.add-picture', [
                                    'single' => true,
                                    'tips' => '证书附件',
                                    'name' => 'certificate_file',
                                    'images' => $certificate_files ?? [],
                                ])
                            </div>
                        </div>
                    </div>

                </aside>

                <div class="text-center">
                    <input type="submit" class="button save" value="保存">
                    <input type="hidden" name="id" value="{{$id ?? 0}}">
                    <input type="hidden" name="brand_id" value="{{$brand_id ?? 0}}">
                    <a class="button clone" href="javascript:history.back()">取消</a>
                </div>
            </form>
        </div>
    </div>
    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.add-picture-item')
    @include('common.prompt-pop',['type'=>1])
@endsection