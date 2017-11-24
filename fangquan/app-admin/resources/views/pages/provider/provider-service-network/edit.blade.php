<?php
ufa()->extCss([
        'provider/provider-service-network/edit'
]);
ufa()->extJs([
        '../lib/jquery-form-validator/jquery.form-validator',
        'provider/provider-service-network/edit',
]);
ufa()->addParam([
        'id'          => $id ?? 0,
        'provider_id' => $provider_id ?? 0,
        'areas'       => $areas ?? [],
        'province_id' => $province_id ?? 0,
        'city_id'     => $city_id ?? 0
]);
?>

@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        @include('partials.provider.nav',['provider_id' =>$provider_id ?? 0])
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">网点添加</p>
                @else
                    <p class="top-title">网点编辑</p>
                @endif
            </div>

            <form id="form" onsubmit="return false">
                <aside>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">网点名称：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="name" value="{{$name or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入网点名称">
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">省份：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="province_id" id="province_id"
                                    data-validation="required length"
                                    data-validation-length="max50"
                                    data-validation-error-msg="请选择省份">
                                <option value="">--请选择--</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">城市：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="city_id" id="city_id"
                                    data-validation="required length"
                                    data-validation-length="max50"
                                    data-validation-error-msg="请选择城市">
                                <option value="">--请选择--</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">地址：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="address" value="{{ $address or '' }}"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入地址">
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">员工数：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="worker_count" value="{{ $worker_count or 0 }}"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入员工数">
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">联系人：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="contact" value=" {{ $contact or '' }}"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入联系人">
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">联系电话：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="telphone" value="{{ $telphone or '' }}"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入联系电话">
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