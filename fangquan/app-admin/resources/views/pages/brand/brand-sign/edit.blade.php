<?php
ufa()->extCss([
        '../lib/datetimepicker/jquery.datetimepicker',
        '../lib/autocomplete/autocomplete',
        'brand/brand-sign/edit'
]);
ufa()->extJs([
        '../lib/jquery-form-validator/jquery.form-validator',
        '../lib/datetimepicker/jquery.datetimepicker',
        '../lib/autocomplete/autocomplete',
        '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
        'brand/brand-sign/edit',
]);
ufa()->addParam([
        'id'          => $id ?? 0,
        "brand_id"    => $brand_id ?? 0,
        'areas'       => $areas ?? [],
        'province_id' => $province_id ?? 0,
        'city_id'     => $city_id ?? 0
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">项目清单新增</p>
                @else
                    <p class="top-title">项目清单编辑</p>
                @endif
            </div>
            <form id="form" onsubmit="return false">
                <aside>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">项目名称：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="" value="{{$loupan_name or ''}}" placeholder="请输入项目名称（下拉联想选择项）"
                                   id="keyword-loupan"
                                   data-="{{$loupan_id or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入项目名称（下拉联想选择项）"/>
                            <input type="hidden" name="loupan_id" value="{{$loupan_id or ''}}">
                            <div class="content-wrap-second"></div>
                            <p class="error-tip-loupan error-tip" style="display: none;">请输入项目名称（下拉联想选择项）</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">所在城市：</label>
                        </div>
                        <div class="small-14 columns">
                            <div class="inline-areas">
                                <select name="province_id" id="province_id"
                                        data-validation="required"
                                        data-validation-error-msg="请选择省份"></select>
                            </div>
                            <div class="inline-areas">
                                <select name="city_id" id="city_id"
                                        data-validation="required"
                                        data-validation-error-msg="请选择城市"></select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">所属开发商：</label>
                        </div>
                        <div class="small-14 columns">
                            <div class="developer-group">
                                <?php $project_developers_i = 0;?>
                                @foreach((!empty($developer_info) ? $developer_info : ['']) as $project_developer)
                                    <div class="error-developers">
                                        <input type="text" name="developer_names[]"
                                               value="{{$project_developer['name'] or ''}}" id="keyword" placeholder="请输入所属开发商（下拉联想选择项）"
                                               class="developer"
                                               data-validation="required length"
                                               data-validation-length="max255"
                                               data-validation-error-msg="请输入所属开发商（下拉联想选择项）"/>
                                        @if($project_developers_i == 0)
                                            <a href="JavaScript:;" class="add-developer">&nbsp;&nbsp;&nbsp;&nbsp;+</a>
                                        @else
                                            <a href="JavaScript:;" class="close-developer">&nbsp;&nbsp;&nbsp;&nbsp;-</a>
                                        @endif
                                        <input id="developer_id" type="hidden" name="developer_ids[]"
                                               value="{{$project_developer['id'] or ''}}"/>
                                    </div>
                                    <?php $project_developers_i++; ?>
                                @endforeach
                                <div class="content-wrap"></div>
                            </div>
                            <p class="error-tip-brand error-tip" style="display: none;">请不要重复添加</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">产品类别：</label>
                        </div>
                        <div class="small-14 columns range">
                            @foreach(($categorys ?? []) as $category)
                                <div class="range-container">
                                    <p>{{$category['name']}}</p>
                                    <div class="range-item">
                                        @foreach(($category['nodes'] ?? []) as $node)
                                            <span>
                                            <input type="checkbox" id="category{{$node['id']}}"
                                                   name="brand_sign_categorys[]"
                                                   value="{{$node['id']}}"
                                                   data-validation="checkbox_group"
                                                   data-validation-qty="min1"
                                                   data-validation-error-msg="请至少选择1项"
                                                   @if(in_array($node['id'], $brand_sign_categorys ?? [])) checked @endif
                                            />
                                            <label for="category{{$node['id']}}">{{$node['name']}}</label>
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">产品型号：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="product_model" value="{{$product_model or ''}}"
                                   placeholder="无型号产品可填写：产品系列或定制产品"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="无型号产品可填写：产品系列或定制产品"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">项目总金额 (万)：</label>
                        </div>
                        <div class="small-14 columns">

                            <input type="text" name="brand_total_amount" value="{{$brand_total_amount or ''}}"
                                   placeholder="请输入数字型项目总金额"
                                   data-validation="number required length"
                                   data-validation-allowing="float"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入数字型项目总金额"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-left">订单签订时间：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" placeholder="请选择订单签订时间" name="order_sign_time" class="date"
                                   value="{{$order_sign_time or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请选择订单签订时间"/>
                        </div>
                    </div>

                </aside>

                <div class="text-center">
                    <input type="submit" class="button save" value="保存">
                    <input type="hidden" name="id" value="{{$id ?? 0}}">
                    <input type="hidden" name="brand_id" value="{{$brand_id ?? 0}}">
                    <a class="button clone" href="javascript:history.back()">取消</a>
                </div>
            </form>
        </div>
    </div>

    <script type="text/html" id="developerTpl">
        <div class="error-developers">
            <input type="text" name="developer_names[]" placeholder="请输入所属开发商（下拉联想选择项）"
                   data-validation="required length"
                   data-validation-length="max50"
                   data-validation-error-msg="请输入所属开发商（下拉联想选择项）"
                   class="developer"/>
            <a href="JavaScript:;" class="close-developer">&nbsp;&nbsp;&nbsp;&nbsp;-</a>
            <input id="developer_id" type="hidden" name="developer_ids[]"
                   value=""/>
        </div>
    </script>

    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.prompt-pop',['type'=>1])
@endsection