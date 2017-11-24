<?php
ufa()->extCss([
    'exhibition/result-detail'
]);
ufa()->extJs([
    'exhibition/result-detail'
]);
?>

@extends('layouts.master')
@section('master.content')
    @include('partials.exhibition.header')
    <div class="exhibition-box">
            <div class="nav">
                <a href="{{route('exhibition.result')}}">展会成果</a>
            </div>
        <div class="exhibition-content">
            <div class="content-box">
                <div class="content-title">
                    <p>{{$title or ''}}</p>
                </div>
                <div class="content-detail">
                    {!! $content or ''!!}
                </div>
            </div>
        </div>
    </div>
    @include('partials.exhibition.friendly-link')
@endsection