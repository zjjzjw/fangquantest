<?php
ufa()->extCss([
        'exhibition/activity'
]);
ufa()->extJs([
        'exhibition/activity'
]);
?>

@extends('layouts.master')
@section('master.content')
    @include('partials.exhibition.header')
    <div class="exhibition-box">
        @include('partials.exhibition.nav')
        <div class="exhibition-content">
            <div class="content-box">
                {!! $content ?? '' !!}
            </div>
        </div>
    </div>
    </div>
    @include('partials.exhibition.friendly-link')
@endsection