<?php
ufa()->extCss([
    '../lib/autocomplete/autocomplete',
    'fq-user/fq-user/index'
]);
ufa()->extJs([
    '../lib/autocomplete/autocomplete',
    'fq-user/fq-user/index',
]);
?>
@extends('layouts.master') @section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                <div class="add-btn">
                    <a href="{{route('fq-user.fq-user.edit',['id'=> 0])}}" class="button">+ 创建账号</a>
                </div>
            </div>

            <div class="search-box">

                <form method="GET" action="" id="" onsubmit="return false">
                    <div class="row">
                        <div class="small-6 columns">
                            <div class="small-8 columns text-right">
                                <label for="right-label" class="text-right">企业名：</label>
                            </div>
                            <div class="small-14 columns">
                                <input type="text" id="keyword" name="company_name" placeholder="请输入企业名"
                                       value="{{$appends['company_name'] or ''}}"
                                       data-company_id="{{$appends['company_id'] or ''}}">
                                <div class="content-wrap"></div>
                            </div>
                        </div>

                        <div class="small-6 columns">
                            <div class="small-8 columns text-right">
                                <label for="right-label" class="text-right">账号/手机号：</label>
                            </div>
                            <div class="small-14 columns">
                                <input type="text" name="keyword" value="{{$appends['keyword'] or ''}}"
                                       placeholder="请输入账号/手机号">
                            </div>
                        </div>

                        <div class="small-6 columns">
                            <div class="small-8 columns text-right">
                                <label for="right-label" class="text-right">账户类型：</label>
                            </div>
                            <div class="small-14 columns">
                                <select name="account_type" id="account_type">
                                    <option value="">--请选择账户类型--</option>
                                    @foreach($account_type_enums as $key => $value)
                                        <option value="{{$key}}"
                                                @if(($appends['account_type'] ?? 0) == $key) selected @endif
                                        >{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="small-6 columns">
                            <div class="small-8 columns text-right">
                                <label for="right-label" class="text-right">注册来源：</label>
                            </div>
                            <div class="small-14 columns">
                                <select name="platform_id" id="platform_id">
                                    <option value="">--请选择注册来源--</option>
                                    @foreach($account_platform_enums as $key => $value)
                                        <option value="{{$key}}"
                                                @if(($appends['platform_id'] ?? 0) == $key) selected @endif
                                        >{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="columns">
                            <input type="submit" class="btn" value="搜索"/>
                            <a href="{{route('fq-user.fq-user.index')}}" class="button reset-btn">重置</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-box">
                <table class="table" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th width="10%">账号</th>
                        <th width="10%">手机号</th>
                        <th width="10%">企业类型</th>
                        <th width="20%">企业名</th>
                        <th width="10%">账号类型</th>
                        <th width="10%">注册来源</th>
                        <th width="10%">到期时间</th>
                        <th width="10%">使用状态</th>
                        <th width="10%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $key => $item)
                        <tr>
                            <td>{{$item['account'] or ''}}</td>
                            <td>{{$item['mobile'] or ''}}</td>
                            <td>{{$item['role_type_name'] or ''}}</td>
                            <td>{{$item['company_name'] or ''}}</td>
                            <td>{{$item['account_type_name'] or ''}}</td>
                            <td>{{ $item['platform_type_name'] or ''}}</td>
                            <td>{{ $item['expire'] or ''}}</td>
                            <td>{{$item['status_name'] or ''}}</td>
                            <td>
                                <a title="编辑" class="icon-edit"
                                   href="{{route('fq-user.fq-user.edit',['id'=>$item['id'] ?? 0])}}">
                                    <i class="iconfont">&#xe626;</i>
                                </a>
                                <a title="密码" class="icon-edit"
                                   href="{{route('fq-user.fq-user.set-password',['id'=>$item['id'] ?? 0])}}">
                                    <i class="iconfont">&#xe739;</i>
                                </a>
                                <a title="绑定开发商供应商" class="icon-edit"
                                   href="{{route('fq-user.fq-user.bind',['id'=>$item['id'] ?? 0])}}">
                                    <i class="iconfont">&#xe60a;</i>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

                {{--分页--}} @if(!$paginate->isEmpty())
                    <div class="patials-paging">
                        {!! $paginate->appends($appends)->render() !!}
                    </div>
                @endif
            </div>

        </div>
    </div>
    @include('common.prompt-pop',['type'=>1])
    @include('common.confirm-pop' ,['type' => 2,'confirm_text' => ""])
@endsection