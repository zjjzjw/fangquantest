<?php
ufa()->extCss([
        'provider/provider-news/edit'
]);
ufa()->extJs([
        '../lib/jquery-form-validator/jquery.form-validator',
        'provider/provider-news/edit',
]);
ufa()->addParam(['id' => $id ?? 0, 'provider_id' => $provider_id ?? 0]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        @include('partials.provider.nav',['provider_id' =>$provider_id ?? 0])
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">企业动态-添加</p>
                @else
                    <p class="top-title">企业动态-编辑</p>
                @endif
            </div>

            <form id="form" onsubmit="return false">
                <aside>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">标题：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="title" value="{{ $title or '' }}"
                                   data-validation="required length"
                                   data-validation-length="max128"
                                   data-validation-error-msg="请输入标题"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">内容：</label>
                        </div>
                        <div class="small-14 columns">
                            <textarea name="content" class="textarea-content"
                                      data-validation="required"
                                      data-validation-error-msg="请输入内容">{{ $content or '' }}</textarea>
                        </div>
                    </div>
                </aside>

                <div class="text-center">
                    <input type="hidden" name="id" value="{{$id ?? 0}}">
                    <input type="hidden" name="provider_id" value="{{$provider_id ?? 0}}">
                    <input type="submit" class="button save" value="保存">
                    <a class="button clone" href="javascript:history.back()">取消</a>
                </div>
            </form>
        </div>
    </div>
    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.prompt-pop',['type'=>1])
@endsection