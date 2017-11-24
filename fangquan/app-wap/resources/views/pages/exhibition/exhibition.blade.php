<?php App\Wap\Http\Controllers\Resource::addCSS(array('css/exhibition/exhibition')); ?>
<?php App\Wap\Http\Controllers\Resource::addJS(array('app/exhibition/exhibition')); ?>
@extends('layouts.master')
@section('content')
    <div class="content-box">
        <div class="bottom-box">
            <p class="title">2017中国首届房地产全产业链B2B创新采购展南方区启动会</p>
            <p class="adress">中国·上海</p>
            <p class="time">2017年11月11日</p>
            <div class="button-box">
                <a href="{{route('exhibition.gather.register',['type' => 3])}}">开发商入口</a>
                <a href="{{route('exhibition.gather.register',['type' => 2])}}">供应商入口</a>
            </div>
        </div>
    </div>
@endsection