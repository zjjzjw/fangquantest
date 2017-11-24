<?php
ufa()->extCss([
        '../lib/autocomplete/autocomplete',
        'provider/provider-certificate/list'
]);
ufa()->extJs([
        '../lib/autocomplete/autocomplete',
        'provider/provider-certificate/list',
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">

            <div class="search-box">

                <form method="GET" action="" id="" onsubmit="return false">
                    <div class="row">
                        <div class="small-8 columns">
                            <div class="small-8 columns text-right">
                                <label for="right-label" class="text-right">公司名称：</label>
                            </div>
                            <div class="small-14 columns">
                                <input type="text" id="keyword" name="company_name"
                                       value="{{$appends['company_name'] or ''}}"
                                       data-provider_id="{{$appends['provider_id'] or ''}}">
                                <div class="content-wrap"></div>
                            </div>
                        </div>


                        <div class="small-8 columns">
                            <div class="small-8 columns text-right">
                                <label for="right-label" class="text-right">关键字：</label>
                            </div>
                            <div class="small-14 columns">
                                <input type="text" name="keyword" value="{{$appends['keyword'] or ''}}">
                            </div>
                        </div>

                        <div class="small-8 columns">
                            <div class="small-8 columns text-right">
                                <label for="right-label" class="text-right">审核状态：</label>
                            </div>
                            <div class="small-14 columns">
                                <select name="status">
                                    <option value="">--请选择审核状态--</option>
                                    @foreach($provider_certificate_statues as $key => $name)
                                        <option value="{{$key}}"
                                                @if(($appends['status'] ?? 0) == $key) selected @endif
                                        >{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="small-10 columns">
                            <input type="submit" class="btn" value="搜索"/>
                            <a href="{{route('provider.provider-certificate.list')}}" class="button reset-btn">重置</a>
                        </div>
                    </div>
                </form>
            </div>


            <div class="table-box">
                <table class="table" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th width="18%">公司名称</th>
                        <th width="18%">品牌名称</th>
                        <th width="18%">证书名称</th>
                        <th width="10%">证书类型</th>
                        <th width="18%">提交时间</th>
                        <th width="10%">审核状态</th>
                        <th width="8%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(($items ?? [] ) as $item)
                        <tr>
                            <td>{{$item['provider']['company_name'] or  ''}}</td>
                            <td>{{$item['provider']['brand_name'] or ''}}</td>
                            <td>{{$item['name']  or ''}}</td>
                            <td>{{$item['type_name']  or ''}}</td>
                            <td>{{ $item['created_at'] or ''}}</td>
                            <td>{{ $item['status_name'] or ''}}</td>
                            <td>
                                <a title="详情" class="icon-edit"
                                   href="{{route('provider.provider-certificate.audit',['id'=> $item['id'] ])}}">
                                    <i class="iconfont">&#xe61b;</i>
                                </a>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{--分页--}}
            @if(!$paginate->isEmpty())
                <div class="patials-paging">
                    {!! $paginate->appends($appends)->render() !!}
                </div>
            @endif
        </div>
    </div>
@endsection
