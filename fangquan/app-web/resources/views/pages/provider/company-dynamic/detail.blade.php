<?php
ufa()->extCss([
        'provider/company-dynamic/detail'
]);
ufa()->extJs([
        'provider/company-dynamic/detail',
]);
?>
@extends('layouts.master')
@section('master.content')
    @include('partials.header')

    <div class="main-content">
    @include('partials.provider.company-desc-top')
    @include('partials.provider.company-info-left')
    <!--右侧-企业动态-->
        <div class="right-box">
            <div class="right-content">
                <h3>{{ $title or '' }}</h3>
                <p>
                    <span>{{ $created_at or '' }}</span>
                </p>
                <div class="content-detail">
                    {!!  $content or ''  !!}
                </div>
            </div>
        </div>
    </div>
@endsection