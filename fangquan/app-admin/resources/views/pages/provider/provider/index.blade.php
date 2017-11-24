<?php
ufa()->extCss([
        'provider/provider/index'
]);
ufa()->extJs([
        'provider/provider/index',
]);
?>
@extends('layouts.master')
@section('master.content')

    <div class="wrapper-box">
        <div class="content-box">

            @if($basic_data['user']->role_type == \App\Src\FqUser\Domain\Model\FqUserRoleType::ADMIN)
                <div class="button-box">
                    <div class="add">
                        <a href="{{route('brand.edit',['id'=>0])}}" class="button add-btn">添加</a>
                    </div>
                </div>
            @endif

            <div class="search-box">

                @if (count($errors) > 0)
                    <p class="error-alert">
                        @foreach ($errors->all() as $key => $error)
                            {{$key + 1}}、 {{ $error }}
                        @endforeach
                    </p>
                @endif

                <form method="GET" action="" id="">
                    <div class="row">
                        <div class="small-8 columns">
                            <div class="small-8 columns text-right">
                                <label for="right-label" class="text-right">唯一标识：</label>
                            </div>
                            <div class="small-14 columns">
                                <input type="text" name="provider_id" value="{{$appends['provider_id'] or ''}}">
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
                    </div>

                    <div class="row">
                        <div class="columns">
                            <input type="submit" class="btn" value="搜索"/>
                        </div>
                    </div>
                </form>
            </div>


            <div class="table-box">
                <table class="table" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th width="5%">编号</th>
                        <th width="20%">公司名称</th>
                        <th width="20%">主营产品</th>
                        <th width="15%">品牌名称</th>
                        <th width="12%">企业商家状态</th>
                        <th width="10%">创建时间</th>
                        <th width="18%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(($items ?? [] ) as $item)
                        <tr>
                            <td>{{$item['id'] or ''}}</td>
                            <td>{{$item['company_name'] or ''}}</td>
                            <td>{{$item['provider_main_category'] or ''}}</td>
                            <td>{{$item['brand_name'] or ''}}</td>
                            <td>{{$item['status_name'] or ''}}</td>
                            <td>{{$item['created_at'] or ''}}</td>
                            <td>
                                @if($basic_data['user']->role_type == \App\Src\FqUser\Domain\Model\FqUserRoleType::PROVIDER)
                                    <a title="品牌编辑" class="icon-edit"
                                       href="{{route('brand.edit',['id' => $item['id'] ?? 0])}}">
                                        <i class="iconfont">&#xe626;</i>
                                    </a>
                                @else
                                    <a title="编辑" class="icon-edit"
                                       href="{{route('provider.provider.edit',['id' => $item['id'] ?? 0])}}">
                                        <i class="iconfont">&#xe626;</i>
                                    </a>
                                    <a title="品牌编辑" class="icon-edit"
                                       href="{{route('brand.edit',['id' => $item['id'] ?? 0])}}">
                                        <i class="iconfont">&#xe66c;</i>
                                    </a>
                                    <a title="删除" class="delete" data-id="{{$item['id'] or ''}}">
                                        <i class="iconfont">&#xe601;</i>
                                    </a>
                                @endif
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

    @include('common.prompt-pop',['type'=>1])
    @include('common.confirm-pop' ,['type' => 2])
@endsection