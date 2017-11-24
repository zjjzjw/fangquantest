<?php
ufa()->extCss([
    'provider/service-network'
]);
ufa()->extJs([
    '../lib/Map/echarts',
    '../lib/Map/china',
    'provider/service-network',
]);
ufa()->addParam(
    [
        'cities' => $cities ?? [],
        'service_network_data' => $service_network_data,
    ]);

?>
@extends('layouts.master')
@section('master.content')
    @include('partials.header')
    <div class="main-content">
    @include('partials.provider.company-desc-top')
    @include('partials.provider.company-info-left')
    <!--右侧-服务网点-->
        <div class="right-box">
            <div class="service-content">
                <div class="map" id="main">

                </div>
            </div>
        </div>
    </div>
@endsection