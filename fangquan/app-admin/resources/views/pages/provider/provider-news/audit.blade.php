<?php
ufa()->extCss([
    'provider/provider-news/audit'
]);
ufa()->extJs([
    'provider/provider-news/audit',
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

                <p class="top-title">供应商企业动态审核内容</p>
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
                            <label class="text-right">标题：</label>
                        </div>
                        <div class="small-14 columns span-box">
                            <span>{{$title or ''}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">内容：</label>
                        </div>
                        <div class="small-14 columns span-box">
                            <span>{{$content or ''}}</span>
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