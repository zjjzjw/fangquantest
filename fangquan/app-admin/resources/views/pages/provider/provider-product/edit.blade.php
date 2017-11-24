<?php
ufa()->extCss([
        'provider/provider-product/edit'
]);
ufa()->extJs([
        '../lib/jquery-form-validator/jquery.form-validator',
        '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
        '../lib/jquery-file-upload/js/jquery.fileupload',
        'provider/provider-product/edit',
]);
ufa()->addParam(['id'               => $id ?? 0,
                 'provider_id'      => $provider_id ?? 0,
                 'product_category' => $product_categories ?? [],
                 'attrib'           => $attrib ?? [],
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        @include('partials.provider.nav',['provider_id' =>$provider_id ?? 0])
        <div class="content-box">

            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">产品添加</p>
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
                            <input type="text" name="name" value="{{$name or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入产品名称">
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">分类：</label>
                        </div>
                        <div class="small-14 columns">
                            <select class="category-id" name="product_category_id"
                                    data-validation="required"
                                    data-validation-error-msg="请选择分类">
                                <option value="">--请选择分类--</option>
                                @foreach($product_categories ?? [] as $product_category )
                                    <option value="{{$product_category['id'] or ''}}"
                                            @if(!empty($product_category_id) && $product_category['id'] == ($product_category_id ?? 0)) selected @endif
                                    >{{$product_category['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">最低参考价：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="price_low" value="{{$price_low or ''}}"
                                   data-validation="required length number" data-validation-allowing="float"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入最低参考价">
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">最高参考价：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="price_high" value="{{$price_high or ''}}"
                                   data-validation="required length number" data-validation-allowing="float"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入最高参考价">
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">产品属性数据</label>
                        </div>
                        <div class="small-14 columns attribute-box">
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
                                    'name' => 'provider_product_images',
                                    'images' => $product_images  ?? [],
                                ])
                            </div>
                            <p class="error-tip-provider_product error-tip" style="display: none;">请上传产品图片</p>
                        </div>
                    </div>

                </aside>

                <div class="text-center">
                    <input type="hidden" name="attrib" value="">
                    <input type="hidden" name="id" value="{{$id ?? 0}}">
                    <input type="hidden" name="provider_id" value="{{$provider_id or 0}}">
                    <input type="submit" class="button save" value="保存">
                    <a class="button clone" href="javascript:history.back()">取消</a>
                </div>
            </form>
        </div>
    </div>
    <script type="text/html" id="attributeList">
        <ul class="attribute">

            <% for ( var j = 0; j < parameter.length; j++ ) { %>
            <p style="padding-top:20px;"><%=parameter[j].name%>：</p>
            <% for ( var i = 0; i < parameter[j].nodes.length; i++ ) { %>
            <li>
                <span class="attribute-name"><%=parameter[j].nodes[i].name%>：</span>
                <input type="text" name="attrib[value][]" value="<%=parameter[j].nodes[i].value%>" />
            </li>
        <% } %>
    <% } %>

</ul>
</script>
@include('common.success-pop')
@include('common.loading-pop')
@include('common.add-picture-item')
@include('common.prompt-pop',['type'=>1])
@endsection
