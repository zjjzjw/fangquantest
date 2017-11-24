<?php
ufa()->extCss([
    'exhibition/provider-list'
]);
ufa()->extJs([
    'exhibition/provider-list'
]);
?>

@extends('layouts.master')
@section('master.content')
    @include('partials.exhibition.header')
    <div class="provider-list-box">
        <div class="img-top">
            <img src="/www/images/exhibition/provider-list.jpg">
        </div>
        @if($items)
            <ul class="provider-item">
                @foreach(($items ?? []) as $item)
                    <li>
                        <a href="{{route('exhibition.developer-project-list',['developer_id' => $item['id']])}}">
                            <img src="{{$item['logo_url'] or ''}}">
                        </a>
                    </li>
                @endforeach
            </ul>
            {{--分页--}}
            @if(!$paginate->isEmpty())
                <div class="patials-paging">
                    {!! $paginate->appends($appends)->render() !!}
                </div>
            @endif
        @else
            @include('common.no-data',['title'=>'暂无内容'])
        @endif
    </div>
    @include('partials.exhibition.friendly-link')
@endsection