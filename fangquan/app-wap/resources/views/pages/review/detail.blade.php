<?php App\Wap\Http\Controllers\Resource::addCSS(array('css/review/detail')); ?>
<?php App\Wap\Http\Controllers\Resource::addJS(array('app/review/detail')); ?>
@extends('layouts.master')
@section('content')
    @include('partials.exhibition-h5.developer.developer-header')
    <div class="content-box">
        <p class="title">{{$title or ''}}</p>
        <p class="detail"><span>{{$publish_at or ''}} </span>编辑：<span>{{$author or ''}}</span></p>
        <div class="content">
            {!! $content or '' !!}
        </div>
    </div>
    @include('partials.exhibition-h5.developer.developer-footer')
@endsection