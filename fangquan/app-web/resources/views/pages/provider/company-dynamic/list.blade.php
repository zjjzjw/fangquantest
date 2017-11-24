<?php
ufa()->extCss([
        'provider/company-dynamic/list'
]);
ufa()->extJs([
        'provider/company-dynamic/list',
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
            @if(!empty($items))
                <ul>
                    @foreach($items as $item)
                        <li>
                            <a href="{{ route('provider.company-dynamic.detail',
                        ['provider_id'=> $provider_id ?? 0 , 'news_id' => $item['id'] ?? 0  ]) }}">
                                {{ $item['title'] or '' }}
                            </a>
                            <span>{{ $item['time_ago'] }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                @include('common.no-data', ['title' => '暂无数据'])
            @endif
            @if(!$paginate->isEmpty())
                <div class="patials-paging">
                    {!! $paginate->render() !!}
                </div>
            @endif
        </div>
    </div>
@endsection