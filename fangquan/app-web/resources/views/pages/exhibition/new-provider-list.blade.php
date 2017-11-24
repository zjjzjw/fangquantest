<?php
ufa()->extCss([
        'exhibition/new-provider-list'
]);
ufa()->extJs([
        'exhibition/new-provider-list'
]);
?>

@extends('layouts.master')
@section('master.content')
    @include('partials.exhibition.header')
    <div class="provider-list">
        <div class="select-box">
            <ul>
                @foreach($categories as $category)
                    <li>
                        <a href="{{route('exhibition.provider.second-level',
                        ['parent_id' => $category['id'], 'second_level' => 0])}}">
                            @if(!empty($category['icon_font']))
                                <i class="iconfont">{{$category['icon_font']}}</i>
                            @else
                                <img src="{{$category['logo_url'] or ''}}" alt="">
                            @endif
                            <p>{{$category['name'] or ''}}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    @include('partials.exhibition.cooperation-unit')
    @include('partials.exhibition.friendly-link')
@endsection