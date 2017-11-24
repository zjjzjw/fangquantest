<?php
ufa()->extCss([
        'exhibition/developer/developer-project'
]);
ufa()->extJs(array(
        'exhibition/developer/developer-project'
));
ufa()->addParam(
        [
                'developer_project_id' => $id ?? 0,
                'token'                => csrf_token(),
        ]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        @include('partials.exhibition.header')
        <div class="content-box">
            <div class="left-box">
                <div class="table-box">
                    <h1>{{$project['title'] or ''}}</h1>
                    <h3>采购需求</h3>
                    <table class="table-purchasing_demand">
                        <tr>
                            <th>项目名称</th>
                            <th class="project-name">{{$project['name'] or ''}}</th>
                        </tr>
                        <tr>
                            <th>项目概况</th>
                            <td>
                                {{$project['summary'] or ''}}
                            </td>
                        </tr>
                    </table>
                    <h3>项目信息</h3>
                    <table class="table-project_information">
                        <tr>
                            <th>招标类型</th>
                            <td>{{$project['developer_project_bidding_type_name'] or ''}}</td>
                            <th>项目类型</th>
                            <td>{{$project['project_category_type_names'] or ''}}</td>
                        </tr>
                        <tr>
                            <th>项目面积</th>
                            <td>{{$project['floor_space'] or 0}}平方米</td>
                            <th>项目区域</th>
                            <td>{{$project['area'] or ''}}</td>
                        </tr>
                        <tr>
                            <th>招标品类</th>
                            <td colspan="3">{{$project['project_category_names'] or ''}}</td>
                        </tr>
                        <tr>
                            <th>地址</th>
                            <td colspan="3">{{$project['address'] or ''}}</td>
                        </tr>
                    </table>
                </div>

            </div>
            <div class="right-box">
                <div class="logo-box">
                    <img src="{{$project['developer_info']['developer_logo_url'] or  ''}}" alt="">
                    <p>{{$project['developer_info']['name'] or  ''}}</p>
                </div>
                <div class="contact-information">
                    <h3>联系方式</h3>
                    <ul>
                        <li>联系人：{{$project['contacts'] or ''}}</li>
                        @if(false)
                            <li>联系电话：{{$project['contacts_phone'] or ''}}</li>
                        @else
                            <li>联系电话：***********</li>
                        @endif
                        <li>联系地址：{{$project['contacts_address'] or ''}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection