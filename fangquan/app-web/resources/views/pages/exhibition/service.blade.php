<?php
ufa()->extCss([
        'exhibition/service'
]);
ufa()->extJs([
        'exhibition/service'
]);
?>

@extends('layouts.master')
@section('master.content')
    @include('partials.exhibition.header')
    <div class="exhibition-box">
        @include('partials.exhibition.service-nav')
        <div class="exhibition-content">
            <article>
                <div class="list-content">
                    <h3 class="fl_1">
                        <i class="icon">
                            <img src="/www/images/exhibitor/01.png" alt="">
                        </i>
                        <a id="daily-planning">参展日程规划</a>
                    </h3>

                    <div class="daily-planning">
                        {!! $daily_planning or '' !!}
                    </div>
                </div>

                <div class="list-content img-box">
                    <h3 class="fl_2">
                        <i class="icon">
                            <img src="/www/images/exhibitor/02.png" alt="">
                        </i>
                        <a id="exhibition-layout">展厅布局</a>
                    </h3>

                    <div class="exhibition-layout">
                         {!! $exhibition_layout or '' !!}
                    </div>

                </div>

                <div class="list-content">
                    <h3 class="fl_3">
                        <i class="icon">
                            <img src="/www/images/exhibitor/03.png" alt="">
                        </i>
                        <a id="exhibition-notice">参展须知</a>
                    </h3>

                    <div class="exhibition-notice">
                          {!! $exhibition_notice or '' !!}
                    </div>
                </div>

                <div class="list-content img-box">
                    <h3 class="fl_4">
                        <i class="icon">
                            <img src="/www/images/exhibitor/04.png" alt="">
                        </i>
                        <a id="exhibition-tour">餐饮交通导览</a>
                    </h3>
                    <div class="exhibition-tour">
                        {!! $exhibition_tour or '' !!}
                    </div>
                </div>

            </article>
        </div>
    </div>
    @include('partials.exhibition.friendly-link')
@endsection