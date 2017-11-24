<?php
ufa()->extCss([
        'regional/city/index',
]);
ufa()->extJs([
        'regional/city/index'
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                <div class="add-btn">
                    <a href="{{route('regional.city.edit',['id'=> 0])}}" class="button">+ 添加城市</a>
                </div>
            </div>

            <div class="search-box">

                @if (count($errors) > 0)
                    <p class="error-alert">
                        @foreach ($errors->all() as $key => $error)
                            {{$key + 1}}、 {{ $error }}
                        @endforeach
                    </p>
                @endif

                <div class="submit">
                    <div class="row">
                        <div class="small-8 columns">
                            <div class="small-8 columns text-right">
                                <label for="right-label" class="text-right"> 省份 </label>
                            </div>

                            <div class="small-14 columns">

                                <select name="province_id">
                                    <option value="">--请选择省份--</option>
                                    @foreach($provinces as $province)
                                        <option @if(($appends['province_id'] ?? 0) == $province['id'])
                                                selected
                                                @endif
                                                value="{{$province['id']}}">{{$province['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="columns">
                            <input type="submit" class="btn" value="搜索"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-box">
                <table class="table" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th width="20%">#</th>
                        <th width="30%">省份名称</th>
                        <th width="30%">城市名称</th>
                        <th width="20%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(($items ?? []) as $item)
                        <tr>
                            <td>{{$item['id'] or 0}}</td>
                            <td>{{$item['province_name'] or ''}}</td>
                            <td>{{$item['name'] or ''}}</td>
                            <td>
                                <a title="编辑" class="icon-edit"
                                   href="{{route('regional.city.edit',['id'=> $item['id']])}}">
                                    <i class="iconfont">&#xe626;</i>
                                </a>
                                <a href="JavaScript:void(0);" title="删除" class="delete" data-id="{{$item['id']}}">
                                    <i class="iconfont">&#xe601;</i>
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
    @include('common.prompt-pop',['type'=>1])
    @include('common.confirm-pop' ,['type' => 2,'confirm_text' => "这条数据"])
@endsection