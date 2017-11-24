<?php
ufa()->extCss([
        'brand/sale-channel/edit'
]);
ufa()->extJs([
        '../lib/jquery-form-validator/jquery.form-validator',
        'brand/sale-channel/edit'
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
                    <p class="top-title">厂家管理新增</p>
                @else
                    <p class="top-title">厂家管理编辑</p>
                @endif
            </div>
            <form id="form" onsubmit="return false">
                <aside>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">渠道销量类型：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="channel_type"
                                    data-validation="required"
                                    data-validation-error-msg="请选择渠道销量类型">
                                <option value="">--选择渠道销量类型--</option>
                                @foreach(($sale_channel_types ?? []) as $key => $name)
                                    <option value="{{$key}}"
                                            @if( ($channel_type ?? 0 ) == $key) selected @endif
                                    >{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">年份：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="sale_year"
                                    data-validation="required"
                                    data-validation-error-msg="请选择年份">
                                <option value="">--选择年份--</option>
                                @foreach(($years ?? []) as $key =>  $name)
                                    <option value="{{$key}}"
                                            @if( ($sale_year ?? 0 ) == $key) selected @endif
                                    >{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">销售金额(万元)：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="sale_volume" value="{{$sale_volume or ''}}"
                                   data-validation="number required length"
                                   data-validation-allowing="float"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入销售金额"/>
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
    @include('common.prompt-pop',['type'=>1])
@endsection