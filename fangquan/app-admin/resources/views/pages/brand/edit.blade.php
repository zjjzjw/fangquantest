<?php
ufa()->extCss([
        '../lib/datetimepicker/jquery.datetimepicker',
        'brand/edit'
]);
ufa()->extJs([
        '../lib/jquery-form-validator/jquery.form-validator',
        '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
        '../lib/jquery-file-upload/js/jquery.fileupload',
        'brand/edit'
]);
ufa()->addParam([
        'id'                  => $id ?? 0,
        'provider_id'         => $provider_id ?? 0,
        'areas'               => $areas ?? [],
        'province_id'         => $province_id ?? 0,
        'city_id'             => $city_id ?? 0,
        'produce_province_id' => $produce_province_id ?? 0,
        'produce_city_id'     => $produce_city_id ?? 0,]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        @include('common.brand-nav',['brand_id'=> $provider_id ?? 0, 'brand_progress' => $brand_progress ?? []])
        <div class="content-box">
            @include('common.press',['brand_id'=> $provider_id ?? 0, 'brand_progress' => $brand_progress ?? []])
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">品牌新增</p>
                @else
                    <p class="top-title">品牌编辑</p>
                @endif
            </div>

            <form id="form" onsubmit="return false">
                <aside>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">公司名称：</label>
                        </div>
                        <div class="small-14 columns">
                            <input name="company_name" type="text"
                                   value="{{$company_name or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入公司名称"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">品牌名称：</label>
                        </div>
                        <div class="small-14 columns">
                            <input class="logo-name" name="brand_name" type="text"
                                   value="{{$brand_name or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入品牌名称"/>
                        </div>
                    </div>

                    <div class="main-protect">
                        <div class="small-8 columns text-right">
                            <label class="text-right">企业品类：</label>
                        </div>
                        <div class="textarea-select type-click" contenteditable="true">
                            <?php if (!empty($product_category_names)) { ?>
                                <?= implode(',', $product_category_names) ?>
                            <?php } else { ?>
                            请选择企业品类
                            <?php } ?>
                        </div>
                        <input class="product_category_ids" type="hidden" name="provider_main_category"
                               value="{{implode(',', $product_category_ids ?? [])}}"/>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">公司类型：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="company_type"
                                    data-validation="required"
                                    data-validation-error-msg="请选择公司类型">
                                <option value="">--选择公司类型--</option>
                                @foreach(($company_types ?? [])  as $key => $name)
                                    <option value="{{$key}}"
                                            @if(($company_type ?? 0) == $key) selected @endif
                                    >{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">Logo：</label>
                        </div>
                        <div class="small-14 columns">
                            <div class="img-box">
                                @include('common.add-picture', [
                                    'single' => true,
                                    'tips' => '上传图片',
                                    'name'   => 'logo',
                                    'images' => $logo_images ?? [],
                                ])
                            </div>
                            <i class="tips-file">*建议图片尺寸为480px * 270px</i>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">企业法人：</label>
                        </div>
                        <div class="small-14 columns">
                            <input name="corp" type="text" value="{{$corp or '' }}" maxlength="30"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入企业法人"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">企业法人联系方式：</label>
                        </div>
                        <div class="small-14 columns">
                            <input name="corp_phone" type="text" value="{{$corp_phone or '' }}" maxlength="11"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">工程经营模式：</label>
                        </div>
                        <div class="small-14 columns">
                            <div class="small-14 columns" style="padding-top: 10px">
                                @foreach(($provider_management_type ?? []) as $key => $name)
                                    <input type="checkbox" name="provider_management_modes[]" value="{{$key}}"
                                           @if(in_array($key, $provider_management_modes ?? [])) checked @endif
                                           id="provider_management_type{{$key}}"
                                           data-validation="checkbox_group"
                                           data-validation-qty="min1"
                                           data-validation-error-msg="请至少选择一项"/>
                                    <label for="provider_management_type{{$key}}">{{$name}}</label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">产品产地：</label>
                        </div>
                        <div class="small-14 columns" style="padding-top: 10px">
                            @foreach(($provider_domestic_import ?? []) as $key => $name)
                                <input type="checkbox" name="provider_domestic_imports[]" value="{{$key}}"
                                       @if(in_array($key, $provider_domestic_imports ?? [])) checked @endif
                                       id="provider_domestic_import{{$key}}"
                                       data-validation="checkbox_group"
                                       data-validation-qty="min1"
                                       data-validation-error-msg="请至少选择一项"/>
                                <label for="provider_domestic_import{{$key}}">{{$name}}</label>
                            @endforeach
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">成立时间：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="founding_time"
                                    data-validation="required"
                                    data-validation-error-msg="请选择成立时间">
                                <option value="">--请选择--</option>
                                <?php for ($year = \Carbon\Carbon::now()->year; $year > \Carbon\Carbon::now()->year - 100; $year--) { ?>

                                <option <?php if ($year == ($founding_time ?? 0)){ ?>selected
                                        <?php } ?> value="<?= $year ?>">
                                    <?= $year ?>
                                </option>

                                <?php } ?>

                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">注册资金：</label>
                        </div>
                        <div class="small-14 columns">
                            <input class="registered-money" type="text" name="registered_capital"
                                   value="{{$registered_capital or ''}}"
                                   data-validation="number required length"
                                   data-validation-allowing="float"
                                   data-validation-length="max11"
                                   data-validation-error-msg="请输入注册资金"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">注册资金单位：</label>
                        </div>
                        <div class="small-14 columns">
                            <input value="{{$registered_capital_unit or ''}}" name="registered_capital_unit"
                                   type="text"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入注册资金单位"/>
                        </div>
                    </div>


                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">年营业额：</label>
                        </div>
                        <div class="small-14 columns">
                            <input value="{{$turnover or ''}}" name="turnover"
                                   type="text"
                                   data-validation="number required length"
                                   data-validation-allowing="float"
                                   data-validation-length="max11"
                                   data-validation-error-msg="请输入年营业额"/>
                            <span>万元</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">员工人数：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" value="{{$worker_count or ''}}" name="worker_count"
                                   data-validation="number required length"
                                   data-validation-length="max11"
                                   data-validation-error-msg="请输入以数字类型的员工人数"/>
                            <span>人</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">生产地址：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="produce_address" value="{{$produce_address or ''}}"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">经营地址：</label>
                        </div>
                        <div class="small-14 columns">
                            <div class="inline-areas">
                                <select name="province_id" id="province_id" class="project_province"
                                        data-validation="required"
                                        data-validation-error-msg="请选择省份"></select>
                            </div>
                            <div class="inline-areas">
                                <select name="city_id" id="city_id" class="project_city"
                                        data-validation="required"
                                        data-validation-error-msg="请选择城市"></select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">经营详细地址：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="operation_address"
                                   value="{{$operation_address or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入经营详细地址"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">品牌联系电话：</label>
                        </div>
                        <div class="small-14 columns">
                            <input name="telphone" type="text" value="{{$telphone or ''}}" maxlength="20"
                                   data-validation="required length"
                                   data-validation-length="max20"
                                   data-validation-error-msg="请输入品牌联系电话"/>
                        </div>
                    </div>


                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">状态：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="status"
                                    data-validation="required"
                                    data-validation-error-msg="请选择公司状态">
                                <option value="">--选择公司状态--</option>
                                @foreach(($provider_statuses ?? [])  as $key => $name)
                                    <option value="{{$key}}"
                                            @if(($status ?? 0) == $key) selected @endif
                                    >{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">企业简介：</label>
                        </div>
                        <div class="small-14 columns company-introduction">
                            <i class="textarea" id="summary">
                                <textarea name="summary" placeholder="">{{$summary or ''}}</textarea>
                                <span class="text"><var class="area">300</var> 字</span>
                            </i>
                        </div>
                    </div>


                    <div class="row" style="display: none;">
                        <div class="small-8 columns text-right">
                            <label class="text-right">营业执照：</label>
                        </div>
                        <div class="small-14 columns">
                            <div class="img-box">
                                @include('common.add-picture', [
                                   'single' => true,
                                   'tips' => '上传图片',
                                   'name'   => 'license',
                                   'images' => $license_images ?? [],
                                ])
                            </div>
                        </div>
                    </div>

                    <div class="row" style="display: none;">
                        <div class="small-8 columns text-right">
                            <label class="text-right">工厂图片：</label>
                        </div>
                        <div class="small-14 columns">
                            <div class="img-box">
                                @include('common.add-picture', [
                                    'single' => false,
                                    'tips' => '上传图片',
                                    'name' => 'provider_factory_image_ids',
                                    'images' => $factory_images  ?? [],
                                ])
                            </div>
                        </div>
                    </div>

                    <div class="row" style="display: none;">
                        <div class="small-8 columns text-right">
                            <label class="text-right">设备图片：</label>
                        </div>
                        <div class="small-14 columns">
                            <div class="img-box">
                                @include('common.add-picture', [
                                    'single' => false,
                                    'tips' => '上传图片',
                                    'name' => 'provider_device_image_ids',
                                    'images' => $device_images  ?? [],
                                ])
                            </div>
                        </div>
                    </div>

                    <div class="row" style="display: none;">
                        <div class="small-8 columns text-right">
                            <label class="text-right">企业架构图：</label>
                        </div>
                        <div class="small-14 columns">
                            <div class="img-box">
                                @include('common.add-picture', [
                                    'single' => true,
                                    'tips' => '上传图片',
                                    'name'   => 'structure',
                                    'images' => $structure_images ?? [],
                                ])
                            </div>
                        </div>
                    </div>

                    <div class="row" style="display: none;">
                        <div class="small-8 columns text-right">
                            <label class="text-right">分支机构架构图：</label>
                        </div>
                        <div class="small-14 columns">
                            <div class="img-box">
                                @include('common.add-picture', [
                                    'single' => true,
                                    'tips' => '上传图片',
                                    'name'   => 'sub_structure',
                                    'images' => $sub_structure_images ?? [],
                                ])
                            </div>
                        </div>
                    </div>


                </aside>

                <div class="text-center">
                    <input name="contact" type="hidden" value="{{$contact or ''}}"/>
                    <input name="fax" type="hidden" value="{{$fax or ''}}"/>
                    <input name="service_telphone" type="hidden" value="{{$service_telphone or ''}}"/>
                    <input name="rank" value="{{$rank or ''}}" type="hidden"/>
                    <input name="is_ad" value="{{$is_ad or ''}}" type="hidden"/>
                    <input name="website" value="{{$website or ''}}" type="hidden"/>

                    <input type="hidden" name="attrib" value="">
                    <input type="hidden" name="id" value="{{$id ?? 0}}">
                    <input type="hidden" name="provider_id" value="{{$provider_id or 0}}">
                    <input type="submit" class="button save" value="保存">
                    <a class="button clone" href="javascript:history.back()">取消</a>
                </div>
            </form>
        </div>
    </div>
    @include('common.add-picture-item')
    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.prompt-pop',['type'=>1])
    @include('common.select-product-pop',['product_categories' => $main_category ?? [],
    'product_category_ids' => $product_category_ids ?? [],])
@endsection