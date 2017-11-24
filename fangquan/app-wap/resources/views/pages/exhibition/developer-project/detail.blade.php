<?php App\Wap\Http\Controllers\Resource::addCSS(array('css/exhibition/developer-project/detail')); ?>
<?php App\Wap\Http\Controllers\Resource::addJS(array('app/exhibition/developer-project/detail')); ?>
@extends('layouts.master')
@section('content')
    @include('partials.exhibition-h5.developer.developer-header')
    <div class="developer-box">
        <div class="logo-box">
            <img src="{{$project['developer_info']['developer_logo_url'] or ""}}" alt="">
            <div class="list-detail">
                <p>{{$project['name'] or ""}}</p>
                <p>{{$project['developer_info']['name'] or ""}}</p>
            </div>
        </div>
        <div class="detail-box">
            <h3>项目信息</h3>
            <table class="table" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>

                    <td class="cell-style">招标类型</td>
                    <td class="cell-develop">{{$project['developer_project_bidding_type_name'] or ""}}</td>
                    <td class="cell-style">项目类型</td>
                    <td class="cell-develop">{{$project['project_category_type_names'] or ""}}</td>
                </tr>
                <tr>
                    <td class="cell-style">建筑面积</td>
                    <td class="cell-develop">{{$project['floor_space'] or ""}}m²</td>

                    <td class="cell-style">发布时间</td>
                    <td class="cell-develop">{{$project['time'] or ""}}</td>
                </tr>
                <tr>

                    <td class="cell-style">招标品类</td>
                    <td colspan="3" class="cell-develop">{{$project['project_category_names'] or ""}}</td>
                </tr>
                <tr>
                    <td class="cell-style">项目区域</td>
                    <td colspan="3" class="cell-develop">{{$project['area'] or ""}}</td>

                </tr>
                <tr>
                    <td class="cell-style">地址</td>
                    <td colspan="3" class="cell-develop">{{$project['address'] or ""}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="detail-box special">
            <h3>采购需求</h3>
            <table class="table" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td class="cell-style">项目名称</td>
                    <td colspan="3" class="cell-develop">{{$project['name'] or ""}}</td>
                </tr>
                <tr>

                    <td class="cell-style special-style">项目介绍</td>
                    <td colspan="3" class="cell-develop">{{$project['summary'] or ""}}</td>

                </tr>
                </tbody>
            </table>
        </div>

        {{--<div class="contact-box">--}}
        {{--<h3>联系方式</h3>--}}
        {{--<table class="table" cellpadding="0" cellspacing="0">--}}
        {{--<tbody>--}}
        {{--<tr>--}}
        {{--<td class="cell-style">--}}

        {{--联系人：{{$project['contacts'] or ""}}<br>--}}
        {{--联系电话：{{$project['contacts_phone'] or ""}}<br>--}}
        {{--联系地址：{{$project['contacts_address'] or ""}}<br>--}}
        {{--邮箱：{{$project['contacts_email'] or ""}}--}}

        {{--</td>--}}
        {{--</tr>--}}
        {{--</tbody>--}}
        {{--</table>--}}
        {{--</div>--}}
    </div>
    @include('partials.exhibition-h5.developer.developer-footer')
@endsection