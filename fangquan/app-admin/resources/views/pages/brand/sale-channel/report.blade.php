<?php
ufa()->extCss([
    'brand/sale-channel/report'
]);
ufa()->extJs([
    'brand/sale-channel/report',
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                <div class="add-btn">
                    <a class="button clone" href="javascript:history.back()">返回</a>
                </div>
            </div>
            <table class="table" cellspacing="0" cellpadding="0">
                <thead>
                <tr>
                    <th width="20%">渠道销量</th>
                    <th width="20%">工程(万元)</th>
                    <th width="20%">电商(万元)</th>
                    <th width="20%">零售(万元)</th>
                    <th width="20%">总量(万元)</th>
                </tr>
                </thead>
                <tbody>
                @foreach(($channels ?? []) as $key => $channel)
                    <tr>
                        <th width="30%">{{$key}}</th>
                        @foreach(($channel ?? []) as $item)
                            <td>{{$item or 0}}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('common.prompt-pop',['type'=>1])
    @include('common.confirm-pop' ,['type' => 2,'confirm_text' => ""])
@endsection