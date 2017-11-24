<?php
ufa()->extCss([
        'provider/history-project'
]);
ufa()->extJs([
        'provider/history-project',
]);
?>
@extends('layouts.master')
@section('master.content')
    @include('partials.header')
    <div class="main-content">
    @include('partials.provider.company-desc-top')
    @include('partials.provider.company-info-left')
    <!--右侧-历史项目-->
        <div class="right-box">
            @if(!empty($items))
                <ul class="project-box">
                    @foreach($items ?? [] as $key => $item)
                        <li>
                            <img src="{{ $item['thumb_pictures'] or '' }}" data-key="{{$key}}">
                            <p class="title">{{ $item['name'] }}</p>
                        </li>
                    @endforeach
                </ul>
            @else
                @include('common.no-data',['title' => '暂无数据'])
            @endif
            @if(!$paginate->isEmpty())
                <div class="patials-paging">
                    {!! $paginate->render() !!}
                </div>
            @endif
        </div>
    </div>
    @include('common.history-project-pop',['items'=>$items])

@endsection