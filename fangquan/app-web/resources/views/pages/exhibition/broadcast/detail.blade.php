<?php
ufa()->extCss([
        'exhibition/broadcast/detail'
]);
ufa()->extJs([
        'exhibition/broadcast/detail'
]);
?>
@extends('layouts.master')
@section('master.content')
    @include('partials.exhibition.header')
    <div class="bg-box">
        <div class="broadcast-box">
            <iframe src="http://shangzhibo.tv/watch/3029616?player"
                    style="width: 1174px; height: 660px; overflow:hidden; " frameborder="0" scrolling="no" allowFullScreen>
            </iframe>
        </div>

    </div>

    @include('partials.exhibition.cooperation-unit')
    @include('partials.exhibition.friendly-link')
@endsection

