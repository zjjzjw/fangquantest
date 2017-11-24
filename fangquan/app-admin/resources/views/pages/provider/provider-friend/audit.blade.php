<?php
ufa()->extCss([
    'provider/provider-friend/audit'
]);
ufa()->extJs([
    'provider/provider-friend/audit',
]);
ufa()->addParam(
    [
        'id' => $id ?? 0,
    ]
);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">

        <div class="content-box">
            <div class="button-box">

                <p class="top-title">供应商战略合作商审核内容</p>
            </div>
            <form id="form" onsubmit="return false">

                <aside>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">公司名称：</label>
                        </div>
                        <div class="small-14 columns span-box">
                            <span>{{$company_name or ''}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">品牌名称：</label>
                        </div>
                        <div class="small-14 columns span-box">
                            <span>{{$brand_name or ''}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">合作开发商名称：</label>
                        </div>
                        <div class="small-14 columns span-box">
                            <span>{{$name or ''}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">链接地址：</label>
                        </div>
                        <div class="small-14 columns span-box">
                            <span>{{$link or ''}}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">Logo：</label>
                        </div>
                        <div class="small-14 columns span-box">
                            <span><img src="{{$logo[0]['url']}}?imageView2/2/w/100/h/100"></span>
                        </div>
                    </div>

                    <div class="text-center">
                        <input type="hidden" name="id" value="{{$id ?? 0}}">
                        @if($status == \App\Src\Provider\Domain\Model\ProviderCertificateStatus::STATUS_PASS)
                            <input type="submit" class="button small-width reject" value="不通过" data-status="1"/>
                        @elseif($status == \App\Src\Provider\Domain\Model\ProviderCertificateStatus::STATUS_REJECT)
                            <input type="submit" class="button small-width save" value="通过" data-status="2"/>
                        @else
                            <input type="submit" class="button small-width reject" value="不通过" data-status="1"/>
                            <input type="submit" class="button small-width save" value="通过" data-status="2"/>
                        @endif
                        <a class="button small-width clone" href="JavaScript:history.back();">取消</a>
                    </div>
                </aside>
            </form>
        </div>
    </div>
    @include('common.loading-pop')
    @include('common.prompt-pop',['type'=>2])
@endsection