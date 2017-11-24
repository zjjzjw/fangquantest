<?php
ufa()->extCss([
    'personal/home'
]);
ufa()->extJs([
    'personal/home'
]);
?>
@extends('layouts.master')
@section('master.content')
    @include('partials.header')
    <div class="main-content">
        @include('pages.personal.personal-left')
        <div class="right-box">
            <h3>欢迎进入房圈</h3>
        </div>
    </div>
@endsection