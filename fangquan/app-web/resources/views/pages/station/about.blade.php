<?php
ufa()->extCss([
    'station/about'
]);
ufa()->extJs([
    'station/about'
]);
?>
@extends('layouts.master')
@section('master.content')
    @include('partials.header')
    <div class="about">
        @include('pages.station.nav')
        <div class="about-content">
            <h3>
                <span>关于房圈</span>
            </h3>
            <article>
                <div class="content">
                    <p>房圈网由上海绘房信息科技有限公司主办，是全国房地产开发行业在互联网上发布招标采购信息和商品及服务信息的房地产综合服务网站，也是与行业联络和交流的公共服务平台。
                        以建立“行业信息中心”、“业务管理中心”和“服务中心”为工作目标，以发布房地产项目招标信息、供应商的产品和服务信息及综合评价为引子，以数据和信息交互为载体撮合房地
                        产上下游企业进行更安全透明的交易的平台。</p>
                    <p>我们成立于2016年，核心研发及产品团队来自行多家业界顶尖的公司，拥有多个项目及平台开发的成功经验。我们的核心团队在在线房地产服务领域已浸淫多年，已经为多家开发商
                        及供应商提供了多种行业解决方案。</p>
                    <p>房圈网秉承三步走的战略，我们首先将会在信息服务领域进行更深入的挖掘，提供更多精准有效的项目信息，为供应商和开发商带来更大的商业价值。</p>
                    <p>我们真心希望能与您携手共同成长，一起在这一领域内做大做强。</p>

                </div>
            </article>
        </div>
    </div>
@endsection