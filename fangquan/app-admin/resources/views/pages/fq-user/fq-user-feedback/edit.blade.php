<?php
ufa()->extCss([
    'fq-user/fq-user-feedback/edit'
]);
ufa()->extJs([
    'fq-user/fq-user-feedback/edit'
]);
ufa()->addParam(
    [
        'id' => $id ?? 0,
    ]
);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">

        <div class="content-box">
            <div class="button-box">

                <p class="top-title">客户反馈</p>
            </div>
            <form id="form" onsubmit="return false">

                <aside>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">昵称：</label>
                        </div>
                        <div class="small-14 columns span-box">
                            <span>{{$fq_user_name or ''}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">联系方式：</label>
                        </div>
                        <div class="small-14 columns span-box">
                            <span>{{$contact or ''}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">反馈内容：</label>
                        </div>
                        <div class="small-14 columns span-box">
                            <span>{{$content or ''}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">来源：</label>
                        </div>
                        <div class="small-14 columns span-box">
                            <span>{{$device or ''}}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">状态：</label>
                        </div>
                        <div class="small-14 columns span-box">
                            <span>{{$status_name or ''}}</span>
                        </div>
                    </div>

                    <div class="text-center">
                        <input type="hidden" name="id" value="{{$id ?? 0}}">
                        <input type="submit" class="button small-width save" value="已处理" data-status="1"/>
                        <input type="submit" class="button small-width reject" value="未处理" data-status="2"/>
                        <a class="button small-width clone" href="JavaScript:history.back();">取消</a>
                    </div>
                </aside>
            </form>
        </div>
    </div>
    @include('common.loading-pop')
    @include('common.prompt-pop',['type'=>2])
@endsection