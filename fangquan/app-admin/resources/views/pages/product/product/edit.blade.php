<?php
ufa()->extCss([
        '../lib/autocomplete/autocomplete',
        'product/edit'
]);
ufa()->extJs([
        '../lib/autocomplete/autocomplete',
        '../lib/jquery-form-validator/jquery.form-validator',
        '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
        '../lib/jquery-file-upload/js/jquery.fileupload',
        'product/edit',
]);
ufa()->addParam([
        'id' => $id ?? 0
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">产品新增</p>
                @else
                    <p class="top-title">产品编辑</p>
                @endif
            </div>


            <form id="form" onsubmit="return false">
                <aside>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">产品名称：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" id="name" name="name" value="{{$name or ''}}"
                                   placeholder="请输入名称,非必填项"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">品牌：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" id="brand_id" value="{{$brand_name or ''}}"
                                   placeholder="请输入品牌（下拉联想选择项）"/>
                            <input type="hidden" name="brand_id" value="{{$brand_id or 0}}"/>
                            <div class="content-wrap"></div>
                            <p class="error-tip-brand_name error-tip" style="display: none;">请输入品牌（下拉联想选择项）</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">型号：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="product_model" value="{{$product_model or ''}}"
                                   placeholder="请输入产品型号"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入产品型号"/>
                        </div>
                    </div>


                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">零售指导价：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="retail_price" value="{{$retail_price or ''}}"
                                   placeholder="两种指导价（零售、工程）至少填写一个"
                                   class="retail-price"
                                   data-validation="number length"
                                   data-validation-allowing="float"
                                   data-validation-length="max50"
                                   data-validation-error-msg="两种指导价（零售、工程）至少填写一个"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">工程指导价：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="engineering_price" value="{{$engineering_price or ''}}"
                                   placeholder="两种指导价（零售、工程）至少填写一个"
                                   class="engineering-price"
                                   data-validation="number length"
                                   data-validation-allowing="float"
                                   data-validation-length="max50"
                                   data-validation-error-msg="两种指导价（零售、工程）至少填写一个"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">指导价单位：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="price_unit" value="{{$price_unit or ''}}" placeholder="请输入指导价单位"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入指导价单位"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">工程参考折扣率：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="product_discount_rate" value="{{$product_discount_rate or ''}}"
                                   placeholder="建议填写,非必填"
                                   data-validation="length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="建议填写，非必填"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">产品产地：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="product_type">
                                <option value="">--选择产地--</option>
                                @foreach($product_types as $key => $value)
                                    <option value="{{$key}}"
                                            @if(($product_type ?? 0) == $key) selected @endif
                                    >{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">产品档次：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="product_grade">
                                <option value="">--选择产品档次--</option>
                                @foreach($product_grades as $key => $value)
                                    <option value="{{$key}}"
                                            @if(($product_grade ?? 0) == $key) selected @endif
                                    >{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label>产品热度（非必选）：</label>
                        </div>
                        <div class="small-14 columns hot-type-box">
                            @foreach($product_hot_types as $key => $hot_type)
                                <input type="checkbox" name="product_hots[]" value="{{$key}}"
                                       @if(in_array($key, $product_hots ?? [])) checked @endif
                                       id="checkbox{{$key}}"/>
                                <label for="checkbox{{$key}}">{{$hot_type}}</label>
                            @endforeach
                        </div>
                    </div>


                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">品类：</label>
                        </div>
                        <div class="small-14 columns">
                            <input class="choose-type" type="text" placeholder="请选择品类" readonly="readonly"
                                   value="{{$product_category_name or ''}}"/>
                            <input type="hidden" id="choose_type" name="product_category_id"
                                   value="{{$product_category_id or 0}}"/>
                            <div class="choose-type-box" style="display: none;">
                                <ul>
                                    @foreach(($category_lists ?? []) as $category)
                                        <li class="first-wrap">
                                            <span>{{$category['name']}}</span>
                                            <ul style="
                                            @if(in_array(($product_category_id ?? 0),$category['node_ids']))
                                                    display: block;
                                            @else
                                                    display: none;
                                            @endif
                                                    ">
                                                @foreach(($category['nodes'] ?? []) as $node)
                                                    <li>
                                                        <input id="radio{{$node['id']}}" type="radio"
                                                               name="category_type"
                                                               data-type-id="{{$node['id']}}"
                                                               value="{{$node['name']}}"
                                                               @if(($product_category_id ?? 0) == $node['id']) checked @endif
                                                        >
                                                        <label for="radio{{$node['id']}}">{{$node['name']}}</label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="attributes-box">
                        @foreach(($category_attributes ?? []) as $category_attribute)
                            <div class="row">
                                <div class="small-8 columns text-right">
                                    <label class="text-right">{{$category_attribute['name']}}：</label>
                                </div>
                                <div class="small-14 columns product_attribute">
                                    @foreach(($category_attribute['attribute_values'] ?? []) as $key => $attribute_value)
                                        <p>
                                            <input type="checkbox" id="product_attribute_ids{{$key}}"
                                                   name="product_attribute_ids[]" value="{{$key}}"
                                                   @foreach($product_attribute_values as $product_attribute_value)
                                                   @if($product_attribute_value['attribute_id'] == $category_attribute['id'] && $product_attribute_value['value_id'] == $key) checked
                                                    @endif
                                                    @endforeach
                                            />
                                            <label for="product_attribute_ids{{$key}}">{{$attribute_value}}</label>
                                        </p>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        @foreach(($category_params ?? []) as $key => $category_param)
                            <div class="row">
                                <div class="small-8 columns text-right">
                                    <label class="text-right">{{$category_param}}：</label>
                                </div>
                                <div class="small-14 columns product_param_value">
                                    <input type="text" name="product_param_val" data-id="{{$key}}"
                                           data-name="{{$category_param}}"
                                           @foreach($product_params as $product_param)
                                           @if($product_param['category_param_id'] == $key)
                                           value="{{$product_param['value'] or ''}}" placeholder="请输入字段内容"
                                           @endif
                                           @endforeach
                                           data-validation="required length"
                                           data-validation-length="max50"
                                           data-validation-error-msg="请输入字段内容"/>
                                    <input type="hidden" name="product_param_value[]"
                                           @foreach($product_params as $product_param)
                                           @if($product_param['category_param_id'] == $key)
                                           value="{{$key}},{{$category_param}},{{$product_param['value'] or ''}}"
                                           @endif
                                           @endforeach
                                           class="product_param_value{{$key}}">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">缩略图：</label>
                        </div>
                        <div class="small-14 columns upload-img">
                            <div class="img-box">
                                @include('common.add-picture', [
                                    'single' => true,
                                    'tips' => '添加图片',
                                    'name' => 'logo',
                                    'images' => $logo  ?? [],
                                ])
                                <i class="tips-file">*建议图片尺寸为400px * 300px</i>
                            </div>
                            <p class="error-tip-logo error-tip" style="display: none;">请上传缩略图</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">详情页图片：</label>
                        </div>
                        <div class="small-14 columns upload-img">
                            <div class="img-box">
                                @include('common.add-picture', [
                                    'single' => false,
                                    'tips' => '添加图片',
                                    'name' => 'product_pictures',
                                    'images' => $product_picture  ?? [],
                                ])
                                <i class="tips-file">*建议图片尺寸为800px * 600px</i>
                            </div>
                            <p class="error-tip-product_picture error-tip" style="display: none;">请上传详情页图片</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">动态参数：</label>
                        </div>
                        <div class="small-14 columns dynamic-parameter">
                            <a href="JavaScript:;" class="add-parameter button">+ 添加动态参数</a>
                            @foreach($product_dynamic_params ?? [] as $product_dynamic)
                                <div>
                                    <div class="parameter-name">
                                        <input type="text" name="product_dynamic[param_name][]"
                                               value="{{$product_dynamic['param_name'] or ''}}"
                                               placeholder="请输入参数名称"
                                               data-validation="required length"
                                               data-validation-length="max50"
                                               data-validation-error-msg="请输入参数名称"/>
                                    </div>

                                    <div class="parameter-name">
                                        <input type="text" name="product_dynamic[param_value][]"
                                               value="{{$product_dynamic['param_value'] or ''}}"
                                               placeholder="请输入参数值"
                                               data-validation="required length"
                                               data-validation-length="max50"
                                               data-validation-error-msg="请输入参数值"/>
                                    </div>
                                    <a href="JavaScript:;" class="move-parameter">&nbsp;&nbsp;&nbsp;&nbsp;-</a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </aside>

                <div class="text-center">
                    <input type="submit" class="button save" value="保存">
                    <input type="hidden" name="id" value="{{$id ?? 0}}">
                    <a class="button clone" href="javascript:history.back()">取消</a>
                </div>
            </form>
        </div>
    </div>

    <script type="text/html" id="attributesTpl">
        <% for ( var j = 0; j < attributes['category_attributes'].length; j++ ) { %>
        <div class="row">
            <div class="small-8 columns text-right">
                <label class="text-right"><%=attributes['category_attributes'][j].name%>：</label>
            </div>
            <div class="small-14 columns product_attribute">
             <% for ( var k in attributes['category_attributes'][j].attribute_values ) { %>
                <p>
                    <input type="checkbox" id="product_attribute_ids<%=k%>" name="product_attribute_ids[]" value="<%=k%>"
                           data-validation="checkbox_group"
                           data-validation-qty="min1"
                           data-validation-error-msg="请至少选择1项"/>
                    <label for="product_attribute_ids<%=k%>"><%=attributes['category_attributes'][j].attribute_values[k]%></label>
                </p>
             <% } %>
            </div>
        </div>
        <% } %>
        <% for ( var k in attributes['category_params'] ) { %>
            <div class="row">
                <div class="small-8 columns text-right">
                    <label class="text-right"><%=attributes['category_params'][k]%>：</label>
                </div>
                <div class="small-14 columns product_param_value">
                    <input type="text" name="product_param_val" data-id="<%=k%>"
                           data-name="<%=attributes['category_params'][k]%>"
                           value="" placeholder="请输入字段内容"/>
                    <input type="hidden" name="product_param_value[]" value="" class="product_param_value<%=k%>">
                </div>
            </div>
        <% } %>
    </script>


    <script type="text/html" id="dynamicTpl">
<div>
        <div class="parameter-name">
            <input type="text" name="product_dynamic[param_name][]" value=""
                    placeholder="请输入参数名称"
                    data-validation="required length"
                    data-validation-length="max50"
                    data-validation-error-msg="请输入参数名称"/>
        </div>
        <div class="parameter-name">
            <input type="text" name="product_dynamic[param_value][]" value=""
                    placeholder="请输入参数值"
                    data-validation="required length"
                    data-validation-length="max50"
                    data-validation-error-msg="请输入参数值"/>
        </div>
        <a href="JavaScript:;" class="move-parameter">&nbsp;&nbsp;&nbsp;&nbsp;-</a>
</div>
    </script>

    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.add-picture-item')
    @include('common.prompt-pop',['type'=>1])
@endsection