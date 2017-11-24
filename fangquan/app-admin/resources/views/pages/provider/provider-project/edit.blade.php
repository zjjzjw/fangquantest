<?php
ufa()->extCss([
        '../lib/datetimepicker/jquery.datetimepicker',
        'provider/provider-project/edit'
]);
ufa()->extJs([
        '../lib/datetimepicker/jquery.datetimepicker',
        '../lib/jquery-form-validator/jquery.form-validator',
        '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
        '../lib/jquery-file-upload/js/jquery.fileupload',
        'provider/provider-project/edit',
]);
ufa()->addParam([
        'id'          => $id ?? 0,
        'provider_id' => $provider_id ?? 0,
        'areas'       => $areas ?? [],
        'province_id' => $province_id ?? 0,
        'city_id'     => $city_id ?? 0
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        @include('partials.provider.nav',['provider_id' => $provider_id ?? 0])
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">历史项目-添加</p>
                @else
                    <p class="top-title">历史项目-编辑</p>
                @endif
            </div>

            <form id="form" onsubmit="return false">
                <aside>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">项目名称：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="name" value="{{ $name or '' }}"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入项目名称">
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">开发商名称：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="developer_name" value="{{ $developer_name or '' }}"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入开发商名称">
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">省份：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="province_id" id="province_id"
                                    data-validation="required length"
                                    data-validation-length="max50"
                                    data-validation-error-msg="请选择省份">
                                <option value="">--请选择--</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">城市：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="city_id" id="city_id"
                                    data-validation="required length"
                                    data-validation-length="max50"
                                    data-validation-error-msg="请选择城市">
                                <option value="">--请选择--</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">合同签订时间：</label>
                        </div>
                        <div class="small-14 columns">
                            <input name="time" type="text" class="date" value="{{ $time or '' }}"
                                   data-validation="required"
                                   data-validation-error-msg="合同签订时间必填"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">产品图片：</label>
                        </div>
                        <div class="small-14 columns upload-img">
                            <div class="img-box">
                                @include('common.add-picture', [
                                    'single' => false,
                                    'tips' => '上传图片',
                                    'name' => 'provider_project_pictures',
                                    'images' => $provider_project_pictures  ?? [],
                                ])
                            </div>
                            <p class="error-tip-project-picture error-tip" style="display: none;">请上传产品图片</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">供应产品：</label>
                        </div>
                        <div class="small-14 columns suppl-products">

                            @if(empty($provider_project_products))
                                <div class="product-value">
                                    <input type="text" name="provider_project_products[name][]" placeholder="产品名称"
                                           value=""
                                           data-validation="required"
                                           data-validation-error-msg="供应产品名称必填">

                                    <input name="provider_project_products[num][]" placeholder="产品数量" type="text"
                                           value=""
                                           data-validation="required"
                                           data-validation-error-msg="产品数量必填">

                                    <select name="provider_project_products[measureunit_id][]" id=""
                                            class="products-name"
                                            data-validation="required"
                                            data-validation-error-msg="产品数量单位必选">
                                        <option value="">--请选择--</option>

                                        @foreach($provider_measureunit_types as $key => $measureunit)
                                            <option value="{{$measureunit['id'] or ''}}">
                                                {{$measureunit['name'] or ''}}
                                            </option>
                                        @endforeach

                                    </select>
                                    <i class="iconfont add-product">&#xe61f;</i>
                                </div>
                            @endif

                            <?php $index = 0 ?>

                            @foreach( $provider_project_products ?? [] as $key => $provider_project_product)
                                <div class="product-value">
                                    <input type="text" name="provider_project_products[name][]"
                                           value="{{ $provider_project_product['name'] or '' }}"
                                           placeholder="产品名称"
                                           data-validation="required"
                                           data-validation-error-msg="供应产品名称必填">

                                    <input name="provider_project_products[num][]" placeholder="产品数量" type="text"
                                           value="{{ $provider_project_product['num'] or '' }}"
                                           data-validation="required"
                                           data-validation-error-msg="产品数量必填">

                                    <select name="provider_project_products[measureunit_id][]" id=""
                                            class="products-name"
                                            data-validation="required"
                                            data-validation-error-msg="产品数量单位必选">
                                        <option value="">--请选择--</option>

                                        @foreach($provider_measureunit_types as $key => $measureunit)
                                            <option @if($provider_project_product['measureunit_id'] == ($measureunit['id'] ?? 0)) selected
                                                    @endif value="{{ $measureunit['id'] or ''}}">
                                                {{ $measureunit['name'] or '' }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @if($index===0)
                                        <i class="iconfont add-product">&#xe61f;</i>
                                    @else
                                        <i class="iconfont del-product">&#xe659;</i>
                                    @endif
                                </div>
                                <?php $index++; ?>
                            @endforeach
                        </div>

                    </div>
                </aside>

                <div class="text-center">
                    <input type="hidden" name="id" value="{{$id ?? 0}}">
                    <input type="hidden" name="provider_id" value="{{$provider_id ?? 0}}">
                    <input type="submit" class="button save" value="保存">
                    <a class="button clone" href="javascript:history.back()">取消</a>
                </div>
            </form>
        </div>
    </div>
    <script type="text/html" id="provider_product_tpl">
        <div class="product-value">
            <input type="text" name="provider_project_products[name][]" value="" placeholder="产品名称"
                   data-validation="required"
                   data-validation-error-msg="供应产品名称必填">

            <input name="provider_project_products[num][]" placeholder="产品数量" type="text"
                   value=""
                   data-validation="required"
                   data-validation-error-msg="产品数量必填">

            <select name="provider_project_products[measureunit_id][]" id="" class="products-name"
                    data-validation="required"
                    data-validation-error-msg="产品数量单位必选">
                <option value="">--请选择--</option>

                @foreach($provider_measureunit_types as $key => $measureunit)
                    <option @if($key == ($measureunit['id'] ?? 0)) selected
                            @endif value="{{ $measureunit['id'] or ''}}">
                        {{ $measureunit['name'] or '' }}
                    </option>
                @endforeach

            </select>

            <i class="iconfont del-product">&#xe659;</i>
        </div>
    </script>
    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.add-picture-item')
    @include('common.prompt-pop',['type'=>1])
@endsection