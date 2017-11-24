<?php
ufa()->extCss([
        'personal/message/list'
]);
ufa()->extJs([
        'personal/message/list'
]);
?>
@extends('layouts.master')
@section('master.content')
    @include('partials.header')
    <div class="main-content">
        @include('pages.personal.personal-left')
        <div class="right-box">
            @if(!empty($user_msg_list['items']))
                <h3>信息中心</h3>
                <ul>
                    @foreach($user_msg_list['items'] as $item)
                        <li data-id="{{$item['id']}}">
                            <a href="JavaScript:;">
                                <i class="iconfont push">&#xe623;</i>
                            </a>
                            <p class=" @if(($item['status'] ?? 0) == \App\Src\Msg\Domain\Model\MsgStatus::NOT_READ) unread @endif">
                                <i class="iconfont"></i>
                                {{$item['title'] or  ''}}
                            </p>
                            <span>{{$item['time']}}</span>
                            <div class="message_content">
                                @foreach($item['images'] as $image_url)
                                    <img src="{{$image_url or ''}}" alt="" style="display: block">
                                @endforeach
                                <p>
                                    {{$item['info'] or ''}}
                                </p>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                {{--分页--}}
                @if(!$user_msg_list['paginate']->isEmpty())
                    <div class="patials-paging">
                        {!! $user_msg_list['paginate']->appends($appends)->render() !!}
                    </div>
                @endif
            @else
                @include('common.no-data', ['title' => '暂无数据'])
            @endif
        </div>
    </div>
    @include('common.back-top')
@endsection