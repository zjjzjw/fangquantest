<?php
ufa()->extCss([
    'station/contact'
]);
ufa()->extJs([
    'station/contact'
]);
?>
@extends('layouts.master')
@section('master.content')
    @include('partials.header')
    <div class="contact">
        @include('pages.station.nav')
        <div class="contact-content">
            <h3>
                <span>联系我们</span>
            </h3>
            <article>
                <div class="content">
                    <div class="content_left">
                        <p>
                            <span>办公地址:</span>
                            <span>上海市普陀区武宁路423号五零创意园5号楼2F</span>
                        </p>
                        <p>
                            <span>邮编:</span>
                            <span>200063</span>
                        </p>
                        <p>
                            <span>联系我们:</span>
                            <span>4000393009</span>
                        </p>
                        <p>
                            <span>市场合作:</span>
                            <span><a href>marketing@fq960.com</a></span>
                        </p>
                        <p>
                            <span>加入我们:</span>
                            <span><a href>hr@fq960.com</a></span>
                        </p>
                    </div>
                    <div class="content-right">
                        <img src="/www/images/station/dt.jpg" alt="">
                    </div>
                </div>
            </article>
        </div>
    </div>
@endsection