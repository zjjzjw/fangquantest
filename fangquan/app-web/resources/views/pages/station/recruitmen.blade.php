<?php
ufa()->extCss([
        'station/recruitmen'
]);
ufa()->extJs([
        'station/recruitmen'
]);
?>

@extends('layouts.master')
@section('master.content')
    @include('partials.header')
    <div class="recruitmen">
        @include('pages.station.nav')
        <div class="recruitmen-content">
            <h3>
                <span>帮助中心</span>
            </h3>
            <div class="content">
                <p>
                    <span>客服热线:</span>
                    <span>4000393009</span>
                </p>
                <p>
                    <span>工作时间</span>
                    <span>周一 到 周五 9:00-18:00</span>
                </p>
            </div>
            <article>
                <div class="content-detail">
                    <h4><i></i>常见问题</h4>
                    <div class="common">
                        <dl class="left">
                            <dt>登录/注册：</dt>
                            <dd>
                                <a href="#signup">如何注册房圈网？</a>
                            </dd>
                            <dd>
                                <a href="#bind">如何通过第三方账号（微信、微博、QQ）登录？</a>
                            </dd>
                            <dd>
                                <a href="#forget-password">忘记密码怎么办？</a>
                            </dd>
                        </dl>
                        <dl class="right">
                            <dt>找供应商：</dt>
                            <dd>
                                <a href="#seek">如何寻找供应商？</a>
                            </dd>
                            <dd>
                                <a href="#contrast">如何进行供应商对比？</a>
                            </dd>
                            <dd>
                                <a href="#product-comparison">如何进行产品对比？</a>
                            </dd>
                        </dl>
                        <div class="clear"></div>
                        <dl class="left">
                            <dt>找项目：</dt>
                            <dd>
                                <a href="#find-project-information">如何寻找项目信息？</a>
                            </dd>
                            <dd>
                                <a href="#competitiveness">如何查看项目的竞争者？</a>
                            </dd>
                        </dl>
                        <dl class="right">
                            <dt>企业管理：</dt>
                            <dd>
                                <a href="#bussiness-identify">如何认证企业？</a>
                            </dd>
                            <dd>
                                <a href="#company-info">如何完善企业信息？</a>
                            </dd>
                            <dd>
                                <a href="#release">如何发布公司产品？</a>
                            </dd>
                            <dd>
                                <a href="#add-project">如何添加公司做过的项目？</a>
                            </dd>
                            <dd>
                                <a href="#release-news">如何发布企业新闻和动态？</a>
                            </dd>
                        </dl>
                        <div class="clear"></div>
                    </div>
                    <div class="problem">
                        <h4><i></i>问题解答</h4>
                        <dl id="signup">
                            <dt>
                                如何注册房圈网？
                            </dt>
                            <dd>点击房圈网顶部导航栏右侧的
                                “<a target="_blank" href="{{ route('register') }}">注册</a>”
                                按钮，进入注册页面进行注册。
                            </dd>
                        </dl>
                        <dl id="bind">
                            <dt>如何通过第三方账号（微信、微博、QQ）登录？</dt>
                            <dd>
                                如果您是通过第三方账号注册的，可在“登录”页面通过第三方账号登录；
                            </dd>
                            <dd>
                                如果账号是有手机、邮箱注册的，可在“个人中心”的
                                “<a target="_blank" href="{{ route('personal.account.account-info') }}">账号</a>”
                                页面绑定第三方账号，然后再登录页面登录。
                            </dd>
                        </dl>
                        <dl>
                            <dt>如何修改密码？</dt>
                            <dd>您可进入“个人中心”的
                                “<a target="_blank" href="{{ route('personal.account.account-info') }}">账号</a>”
                                页面，进行修改密码。
                            </dd>
                        </dl>
                        <dl id="forget-password">
                            <dt>忘记密码怎么办？</dt>
                            <dd>您可在
                                “<a target="_blank" href="{{ route('login') }}">登录</a>”
                                页面，点击登录框下面“忘记密码”，通过绑定的手机或邮箱，按照提示找回。
                            </dd>
                        </dl>
                        <dl id="seek">
                            <dt>如何寻找供应商？</dt>
                            <dd>您可在
                                “<a target="_blank" href="{{ route('provider.list') }}">找供应商</a>”
                                页面，通过顶部导航栏搜索，也可以再页面内筛选找到您想要的供应商。
                            </dd>
                        </dl>
                        <dl id="contrast">
                            <dt>如何进行供应商对比？</dt>
                            <dd>您可在
                                “<a target="_blank" href="{{ route('provider.list') }}">找供应商</a>”
                                页面，点击供应商LOGO下方的“对比”按钮，加入到对比框，进行对比；
                            </dd>
                            <dd>
                                也可以再
                                “供应商详情”
                                页面，点击上方的“加入对比”按钮，加入到对比框，进行对比。
                            </dd>
                        </dl>
                        <dl id="product-comparison">
                            <dt>如何进行产品对比？</dt>
                            <dd>您可在
                                “产品详情”
                                页面，点击产品图片右侧的“加入对比”按钮，加入到对比框，进行对比；
                            </dd>
                            <dd>
                                只可将同类型的产品进行对比。
                            </dd>
                        </dl>
                        <dl id="find-project-information">
                            <dt>如何寻找项目信息？</dt>
                            <dd>
                                您可在
                                “<a target="_blank" href="{{ route('developer.developer-project.list') }}">找项目</a>”
                                页面，通过顶部导航栏搜索，也可以再页面内筛选找到您想要的项目信息。
                            </dd>
                        </dl>
                        <dl id="competitiveness">
                            <dt>如何查看项目的竞争者？</dt>
                            <dd>
                                当您查看了项目的联系人后，系统会自动计算您在该项目中的竞争力。进入“个人中心”-
                                “竞争力分析”
                                页面，可查看自己在该项目中的竞争力分析报告。
                            </dd>
                        </dl>
                        <dl>
                            <dt>如何了解哪些企业对我感兴趣？</dt>
                            <dd>
                                您可在“个人中心”-
                                “谁看过我”
                                页面，看到一周内有哪些企业浏览过您公司的页面，以及查看了哪些项目、哪些产品等详细浏览记录。
                            </dd>
                        </dl>
                        <dl id="bussiness-identify">
                            <dt>如何认证企业？</dt>
                            <dd>
                                您可在“个人中心”-
                                “企业认证”
                                页面，填写相关企业信息进行认证。
                            </dd>
                        </dl>
                        <dl id="company-info">
                            <dt>如何完善企业信息？</dt>
                            <dd>
                                您可在“个人中心”-
                                “企业信息”
                                页面，编辑公司的企业信息。
                            </dd>
                        </dl>
                        <dl id="release">
                            <dt>如何发布公司产品？</dt>
                            <dd>
                                您可在“个人中心”-
                                “产品方案”
                                页面，发布公司的产品方案。
                            </dd>
                        </dl>
                        <dl id="add-project">
                            <dt>如何添加公司做过的项目？</dt>
                            <dd>
                                您可在“个人中心”-
                                “历史项目”
                                页面，编辑公司的历史项目。
                            </dd>
                        </dl>
                        <dl id="release-news">
                            <dt>如何发布企业新闻和动态？</dt>
                            <dd>
                                您可在“个人中心”-
                                “企业动态”
                                页面，编辑公司的企业动态。
                            </dd>
                        </dl>
                    </div>
                </div>
            </article>
        </div>
    </div>
@endsection