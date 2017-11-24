<?php
ufa()->extCss([
    'exhibition/flashback/detail'
]);
ufa()->extJs([
    'exhibition/flashback/detail'
]);

?>

@extends('layouts.master')
@section('master.content')
    @include('partials.exhibition.header')
    <div class="exhibition-box">
        @include('partials.exhibition.nav')
        <div class="exhibition-content">
            <div class="content-box">
                <div class="content-title">
                    <p>{{$title or ''}}</p>
                </div>
                <div class="content-detail">
                   {!! $content or '' !!}
                </div>
            </div>
        </div>
    </div>
    @include('partials.exhibition.friendly-link')
@endsection