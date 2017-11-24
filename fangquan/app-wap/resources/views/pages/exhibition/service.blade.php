<?php App\Wap\Http\Controllers\Resource::addCSS(array('css/exhibition/service')); ?>
<?php App\Wap\Http\Controllers\Resource::addJS(array('app/exhibition/service')); ?>
@extends('layouts.master')
@section('content')
    <div class="service">
        @include('partials.exhibition-h5.header')
        <div class="list-content">
            <h3>
                <i class="icon">
                    <img src="/www/image/exhibition/service/01.png" alt="">
                </i>
                <a id="daily-planning">参展日程规划</a>
            </h3>

            <div class="service-contenet">
                {!! $daily_planning or '' !!}
            </div>
        </div>

        <div class="list-content">
            <h3 class="fl_2">
                <i class="icon">
                    <img src="/www/image/exhibition/service/02.png" alt="">
                </i>
                <a id="exhibition-layout">展厅布局</a>
            </h3>

            <div class="service-contenet">
                {!! $exhibition_layout or '' !!}
            </div>

        </div>

        <div class="list-content">
            <h3 class="fl_3">
                <i class="icon">
                    <img src="/www/image/exhibition/service/03.png" alt="">
                </i>
                <a id="exhibition-notice">参展须知</a>
            </h3>

            <div class="service-contenet">
                {!! $exhibition_notice or '' !!}
            </div>
        </div>

        <div class="list-content">
            <h3 class="fl_4">
                <i class="icon">
                    <img src="/www/image/exhibition/service/04.png" alt="">
                </i>
                <a id="exhibition-tour">餐饮交通导览</a>
            </h3>
            <div class="service-contenet">
                {!! $exhibition_tour or '' !!}
            </div>
        </div>
        @include('partials.exhibition-h5.footer')
    </div>
@endsection