<?php
ufa()->extCss([
        'developer/list'
]);
ufa()->extJs([
        'developer/list'
]);
?>
@extends('layouts.master')
@section('master.content')
    @include('partials.header')
    <div class="main-content">
        <div class="bannen"></div>
        <div class="list-content">
            <div class="ranking-list">
                <h3>中国房地产开发商100强 · 排行榜</h3>
                <?php $i = 0; $j = 1; ?>
                @foreach($providers as $key => $items)
                    <div class="top-ranking">
                        <h4>{{$i*10+1}}-{{($i+1)*10}}</h4>
                        <ul>
                            @foreach($items as $item)
                                <li>
                                    <i class="bg-top  @if($j<=3) bg-top{{$j}} @endif">{{$j}}</i>
                                    <a target="_blank"
                                       href="javascript:void(0);">
                                        <img src="{{$item['logo_url'] or ''}}"
                                             class="top-bannen-logo">
                                    </a>
                                </li>
                                <?php $j++; ?>
                            @endforeach
                        </ul>
                    </div>
                    <?php  $i++; ?>
                @endforeach
            </div>
        </div>
        @include('common.back-top')
    </div>
@endsection