<?php
ufa()->extCss([
        'category/edit'
]);
ufa()->extJs([
        '../lib/jquery-form-validator/jquery.form-validator',
        '../lib/jquery-file-upload/js/vendor/jquery.ui.widget',
        '../lib/jquery-file-upload/js/jquery.fileupload',
        'category/edit'
]);
ufa()->addParam([
        'id'         => $id ?? 0,
        'attributes' => $attributes ?? [],
]);
?>
@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">品类新增</p>
                @else
                    <p class="top-title">品类编辑</p>
                @endif
            </div>
            <form id="form" onsubmit="return false">
                <aside>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">品类：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="name" value="{{$name or ''}}"
                                   data-validation="required length" placeholder="请输入品类"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入品类"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">排序：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="order" value="{{$order or 0}}" maxlength="11" placeholder="请输入排序"
                                   data-validation="required length"
                                   data-validation-length="max11"
                                   data-validation-error-msg="请输入排序"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">面价单位：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="price" value="{{$price or ''}}"
                                   data-validation="length" placeholder="请输入面价单位"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入面价单位"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">Icon：</label>
                        </div>
                        <div class="small-14 columns upload-img">
                            <div class="img-box">
                                @include('common.add-picture', [
                                    'single' => true,
                                    'tips' => '上传图片',
                                    'name' => 'image_id',
                                    'images' => $thumbnail_images ?? [],
                                ])
                            </div>
                            <p class="error-tip-picture error-tip" style="display: none;">请上传产品图片</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">Iconfont(矢量图)：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="icon_font" value="{{$icon_font or ''}}"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">属性：</label>
                        </div>
                        <div class="small-14 columns category_attributes">
                            <?php $category_attributes_i = 0; ?>
                            @foreach((!empty($category_attributes) ? $category_attributes : ['']) as $key => $name)
                                <p>
                                    <select name="category_attributes[]" id="">
                                        <option value="">--选择属性--</option>
                                        @foreach(($attributes ?? []) as $attribute)
                                            <option value="{{$attribute['id'] or 0}}"
                                                    @if($attribute['id'] == $key)
                                                    selected
                                                    @endif
                                            >{{$attribute['name'] or ''}}</option>
                                        @endforeach
                                    </select>
                                    @if($category_attributes_i == 0)
                                        <a href="JavaScript:;" class="add-attributes">&nbsp;&nbsp;&nbsp;+</a>
                                    @else
                                        <a href="JavaScript:;" class="reduce-attributes">&nbsp;&nbsp;&nbsp;-</a>
                                    @endif
                                </p>
                                <?php $category_attributes_i++; ?>
                            @endforeach
                            <div class="error-message"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns text-right">
                            <label class="text-right">参数名：</label>
                        </div>
                        <div class="small-14 columns category_params">
                            <?php $category_params_i = 0; ?>
                            @foreach((!empty($category_params) ? $category_params : ['']) as $key => $name)
                                <p>
                                    <input type="hidden" name="category_attribute_ids[]" value="{{$key}}">
                                    <input type="text" name="category_params[]" value="{{$name or ''}}"
                                           placeholder="请输入参数名"
                                           data-validation="length"
                                           data-validation-length="max50"
                                           data-validation-error-msg="请输入参数名"/>
                                    @if($category_params_i == 0)
                                        <a href="JavaScript:;" class="add-params">&nbsp;&nbsp;&nbsp;+</a>
                                    @else
                                        <a href="JavaScript:;" class="reduce-params">&nbsp;&nbsp;&nbsp;-</a>
                                    @endif
                                </p>
                                <?php $category_params_i++; ?>
                            @endforeach
                        </div>
                    </div>
                </aside>

                <div class="text-center">
                    <input type="submit" class="button save" value="保存">
                    <input type="hidden" name="id" value="{{$id ?? 0}}">
                    <input type="hidden" name="parent_id" value="{{$parent_id ?? 0}}">
                    <a class="button clone" href="javascript:history.back()">取消</a>
                </div>
            </form>
        </div>
    </div>
    <script type="text/html" id="attributesTpl">
        <p>
            <select name="category_attributes[]" id="">
                <option value="">--选择属性--</option>
                <% for ( var k = 0; k < attributes.length; k++ ) { %>
                <option value="<%=attributes[k].id%>"><%=attributes[k].name%></option>
                <% } %>
            </select>
            <a href="JavaScript:;" class="reduce-attributes">&nbsp;&nbsp;&nbsp;-</a>
        </p>

    </script>

    <script type="text/html" id="category_paramsTpl">
         <p>
                <input type="text" name="category_params[]" value="" placeholder="请输入参数名"
                   data-validation="length"
                   data-validation-length="max50"
                   data-validation-error-msg="请输入产品"/>
                <a href="JavaScript:;" class="reduce-params">&nbsp;&nbsp;&nbsp;-</a>
            </div>
         </p>
    </script>

    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.add-picture-item')
    @include('common.prompt-pop',['type'=>1])
@endsection