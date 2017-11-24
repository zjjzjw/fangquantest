<?php
ufa()->extCss([
        'exhibition/provider/service-network'
]);
ufa()->extJs(array(
        'exhibition/provider/service-network'
));
ufa()->addParam(
        [
                'cities' => $cities ?? [],
        ]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        @include('partials.exhibition.header')
        @include('partials.exhibition.provider.provider-header', ['provider_id' => $provider['id'], 'provider' => $provider])
        <div class="content-box">
            @include('partials.exhibition.provider.provider-left', ['provider' => $provider ])
            <div class="provider-right">
                <div class="img-box">
                    @foreach($brand_service['files'] ?? [] as $image)
                        <img src="{{$image['url'] or ''}}">
                    @endforeach
                </div>
                <ul>
                    <li>服务能力范围：{{$brand_service['service_range'] or ''}}</li>
                    <li>质保期限：{{$brand_service['warranty_range'] or ''}}</li>
                    <li>服务模式：{{$brand_service['service_model_name'] or ''}}</li>
                    <li>供货周期：{{$brand_service['supply_cycle'] or ''}}</li>
                </ul>
            </div>

        </div>
    </div>

@endsection