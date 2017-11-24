<?php
ufa()->extCss([
    'review/detail'
]);
ufa()->extJs([
    'review/detail'
]);
?>

@extends('layouts.master')
@section('master.content')
    @include('partials.exhibition.header')
    <div class="detail-box">
        <div class="detail-content">
            <p class="title">{{$title or ''}}</p>
            <p class="time"><span>{{$publish_at or ''}} </span>编辑：<span>{{$author or ''}}</span></p>
            <div class="content-list">
                {!! $content or '' !!}
            </div>
        </div>
    </div>
    @include('partials.exhibition.friendly-link')
@endsection