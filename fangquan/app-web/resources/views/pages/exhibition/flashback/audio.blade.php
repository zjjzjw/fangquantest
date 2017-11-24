<?php
ufa()->extCss([
    'exhibition/flashback/audio'
]);
ufa()->extJs([
    'exhibition/flashback/audio'
]);

?>

@extends('layouts.master')
@section('master.content')
    @include('partials.exhibition.header')
    <div class="exhibition-box">
        @include('partials.exhibition.nav')
        <div class="exhibition-content">
            <div class="content-box">
                <video preload="auto" controls="controls"
                       src="{{$audio_images[0]['audio_url'] or ''}}"></video>
            </div>
        </div>
    </div>
    @include('partials.exhibition.friendly-link')
@endsection