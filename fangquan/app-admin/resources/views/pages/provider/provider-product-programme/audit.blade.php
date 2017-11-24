<?php
ufa()->extCss([
    'provider/provider-product-programme/audit'
]);
ufa()->extJs([
    'provider/provider-product-programme/audit',
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

                <p class="top-title">供应商产品方案审核内容</p>
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
                            <label class="text-right">方案标题：</label>
                        </div>
                        <div class="small-14 columns span-box">
                            <span>{{$title or ''}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">方案描述：</label>
                        </div>
                        <div class="small-14 columns span-box">
                            <span>{{$desc or ''}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">方案产品：</label>
                        </div>
                        <div class="small-14 columns span-box">
                            <span>
                                @foreach(($programme_images ?? []) as $programme_image)
                                    <img src="{{$programme_image['url'] or ''}}?imageView2/2/w/100/h/100">
                                @endforeach
                            </span>
                        </div>
                    </div>

                    <div class="text-center">
                        <input type="hidden" name="id" value="{{$id ?? 0}}">
                        @if($status == \App\Src\Provider\Domain\Model\ProviderProductProgrammeStatus::STATUS_PASS)
                            <input type="submit" class="button small-width reject" value="不通过" data-status="1"/>
                        @elseif($status == \App\Src\Provider\Domain\Model\ProviderProductProgrammeStatus::STATUS_REJECT)
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