<?php
ufa()->extCss([
        '../lib/datetimepicker/jquery.datetimepicker',
        'developer/developer-project/edit'
]);
ufa()->extJs([
        '../lib/datetimepicker/jquery.datetimepicker',
        '../lib/jquery-form-validator/jquery.form-validator',
        'developer/developer-project/edit'
]);

ufa()->addParam([
        'id'           => $id ?? 0,
        'areas'        => $areas ?? [],
        'province_id'  => $province_id ?? 0,
        'city_id'      => $city_id ?? 0,
        'developer_id' => $developer_id ?? 0
]);
?>

@extends('layouts.master')
@section('master.content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="button-box">
                @if(empty($id))
                    <p class="top-title">开发商项目-添加</p>
                @else
                    <p class="top-title">开发商项目-编辑</p>
                @endif
            </div>
            <form id="form" onsubmit="return false">

                <aside>
                    <div class="row">
                        <div class="small-8 columns ">
                            <label>项目名称：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="name" value="{{$name or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入项目名称"/>
                        </div>
                    </div>


                    <div class="row">
                        <div class="small-8 columns ">
                            <label>项目阶段：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="project_stage_id"
                                    data-validation="required"
                                    data-validation-error-msg="请选择项目阶段">
                                <option value="">--请选择--</option>
                                @foreach($developer_project_stages as $developer_project_stage)
                                    <option value="{{$developer_project_stage['id']}}"
                                            @if(($project_stage_id ?? 0) == $developer_project_stage['id'])
                                            selected
                                            @endif
                                    >{{$developer_project_stage['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="row">
                        <div class="small-8 columns ">
                            <label>是否优质项目：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="is_great" value="">
                                <option value="">--请选择--</option>
                                @foreach($developer_project_great_type as $key => $name)
                                    <option value="{{$key}}"
                                            @if(($is_great ?? 0) == $key) selected @endif
                                    >{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>涉及产品分类：</label>
                        </div>
                        <div class="small-14 columns product-categorys">
                            <div class="textarea-select type-click" contenteditable="true">
                                @if(!empty($product_category_names))
                                    {{$product_category_names or ''}}
                                @else
                                    请选择产品分类
                                @endif
                            </div>
                            <input class="product_category_ids" type="hidden" name="developer_project_category"
                                   value="{{implode(',', $product_category_ids ?? [])}}"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>涉及项目分类：</label>
                        </div>
                        <div class="small-14 columns project-categorys">
                            <div class="textarea-select type-click" contenteditable="true">
                                @if(!empty($developer_project_has_project_category_names))
                                    {{$developer_project_has_project_category_names or ''}}
                                @else
                                    请选择项目分类
                                @endif
                            </div>
                            <input class="project_category_ids" type="hidden" name="project_category_ids"
                                   value="{{implode(',', $develop_project_has_project_category_ids ?? [])}}"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>省份：</label>
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
                        <div class="small-8 columns ">
                            <label>城市：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="city_id" id="city_id"
                                    data-validation="required"
                                    data-validation-error-msg="请选择城市">
                                <option value="">--请选择--</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>地址：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="address" value="{{ $address or '' }}"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入地址">
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>造价(万)：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="cost" value="{{$cost or 0}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入造价"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>项目类别：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="type" id="province_id"
                                    data-validation="required"
                                    data-validation-error-msg="请选择项目类别">
                                <option value="">--请选择--</option>
                                @foreach($developer_project_type as $key => $name)
                                    <option value="{{$key}}"
                                            @if(($type ?? 0) == $key) selected @endif
                                    >{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>设计阶段：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="stage_design"
                                    data-validation="required"
                                    data-validation-error-msg="请选择设计阶段">
                                <option value="">--请选择--</option>
                                @foreach($developer_project_stage_design_type as $key => $name)
                                    <option value="{{$key}}"
                                            @if(($stage_design ?? 0) == $key) selected @endif
                                    >{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>施工阶段：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="stage_build"
                                    data-validation="required"
                                    data-validation-error-msg="请选择施工阶段">
                                <option value="">--请选择--</option>
                                @foreach($developer_project_stage_build_type as $key => $name)
                                    <option value="{{$key}}"
                                            @if(($stage_build ?? 0) == $key) selected @endif
                                    >{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>装修阶段：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="stage_decorate"
                                    data-validation="required"
                                    data-validation-error-msg="请选择装修阶段">
                                <option value="">--请选择--</option>
                                @foreach($developer_project_stage_decorate_type as $key => $name)
                                    <option value="{{$key}}"
                                            @if(($stage_decorate ?? 0) == $key) selected @endif
                                    >{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>建筑面积(平米)：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="floor_space" value="{{$floor_space or 0}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入建筑面积"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>建筑层数：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="floor_numbers" value="{{$floor_numbers or 0}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入建筑层数"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>总投资额：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="investments" value="{{$investments or 0}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入总投资额"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>供暖方式：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="heating_mode" value="{{$heating_mode or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入供暖方式"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>外墙材料：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="wall_materials" value="{{$wall_materials or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max255"
                                   data-validation-error-msg="请输入外墙材料"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>是否精装修：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="has_decorate"
                                    data-validation="required"
                                    data-validation-error-msg="请选择是否精装修">
                                <option value="">--请选择--</option>
                                @foreach($developer_project_decorate_type as $key => $name)
                                    <option value="{{$key}}"
                                            @if(($has_decorate ?? 0) == $key) selected @endif
                                    >{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>有无空调：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="has_airconditioner"
                                    data-validation="required"
                                    data-validation-error-msg="请选择有无空调">
                                <option value="">--请选择--</option>
                                @foreach($developer_project_airconditioner_type as $key => $name)
                                    <option value="{{$key}}"
                                            @if(($has_airconditioner ?? 0) == $key) selected @endif
                                    >{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>有无钢结构：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="has_steel"
                                    data-validation="required"
                                    data-validation-error-msg="请选择有无钢结构">
                                <option value="">--请选择--</option>
                                @foreach($developer_project_steel_type as $key => $name)
                                    <option value="{{$key}}"
                                            @if(($has_steel ?? 0) == $key) selected @endif
                                    >{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>有无电梯：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="has_elevator"
                                    data-validation="required"
                                    data-validation-error-msg="请选择有无电梯">
                                <option value="">--请选择--</option>
                                @foreach($developer_project_elevator_type as $key => $name)
                                    <option value="{{$key}}"
                                            @if(($has_elevator ?? 0) == $key) selected @endif
                                    >{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>项目开始时间：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="time_start" value="{{$time_start or ''}}" class="date"
                                   data-validation="required"
                                   data-validation-error-msg="请输入项目开始时间"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>项目结束时间：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="time_end" value="{{$time_end or ''}}" class="date"
                                   data-validation="required"
                                   data-validation-error-msg="请输入项目结束时间"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>联系人：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="contacts" value="{{$contacts or ''}}"
                                   data-validation="required"
                                   data-validation-error-msg="请输入联系人"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>联系电话：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="contacts_phone" value="{{$contacts_phone or ''}}"
                                   data-validation="required"
                                   data-validation-error-msg="请输入联系电话"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>联系邮箱：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="contacts_email" value="{{$contacts_email or ''}}"
                                   data-validation="required"
                                   data-validation-error-msg="请输入联系邮箱"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>联系地址：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="contacts_address" value="{{$contacts_address or ''}}"
                                   data-validation="required"
                                   data-validation-error-msg="请输入联系地址"/>
                        </div>
                    </div>


                    <div class="row">
                        <div class="small-8 columns ">
                            <label>状态：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="status"
                                    data-validation="required"
                                    data-validation-error-msg="请选择状态">
                                <option value="">--请选择--</option>
                                @foreach($developer_project_status as $key => $name)
                                    <option value="{{$key}}"
                                            @if(($status ?? 0) == $key) selected @endif
                                    >{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>是否广告：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="is_ad"
                                    data-validation="required"
                                    data-validation-error-msg="请选择是否广告">
                                <option value="">--请选择--</option>
                                @foreach($developer_project_ad_type as $key => $name)
                                    <option value="{{$key}}"
                                            @if(($is_ad ?? 0) == $key) selected @endif
                                    >{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>区域：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="area" value="{{$area or ''}}"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>招标类型 ：</label>
                        </div>
                        <div class="small-14 columns">
                            <select name="bidding_type"
                                    data-validation="required"
                                    data-validation-error-msg="请选择招标类型">
                                <option value="">--请选择--</option>

                                @foreach($developer_project_bidding_type as $key => $name)
                                    <option value="{{$key}}"
                                            @if(($bidding_type ?? 0) == $key) selected @endif
                                    >{{$name}}</option>
                                @endforeach


                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-8 columns ">
                            <label>报名截止时间：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="deadline_for_registration"
                                   value="{{$deadline_for_registration or ''}}"
                                   data-validation="required length"
                                   data-validation-length="max50"
                                   data-validation-error-msg="请输入报名截止时间"/>
                        </div>
                    </div>


                    <div class="row">
                        <div class="small-8 columns ">
                            <label>其他：</label>
                        </div>
                        <div class="small-14 columns">
                            <input type="text" name="other" value="{{$other or ''}}"/>
                        </div>
                    </div>

                    <br>
                    <div class="row">
                        <div class="small-8 columns ">
                            <label>项目类型(可多选)：</label>
                        </div>
                        <div class="small-14 columns project-category">
                            <div class="category-container">
                                <div class="category-item">
                                    @foreach($developer_project_category_type as $key => $name)
                                        <span>
                                            <input type="checkbox" id="project_categories{{$key}}"
                                                   name="project_categories[]"
                                                   value="{{$key}}"
                                                   data-validation="checkbox_group"
                                                   data-validation-qty="min1"
                                                   data-validation-error-msg="请至少选择1项"
                                                   @if(in_array($key, $project_categories ?? [])) checked @endif/>
                                            <label for="project_categories{{$key}}">{{$name}}</label>
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="row textarea">
                        <div class="small-8 columns">
                            <label>项目概况：</label>
                        </div>
                        <div class="small-16 columns">
                            <textarea name="summary"
                                      data-validation="required"
                                      data-validation-error-msg="请输入项目概况">{!! $summary or '' !!}</textarea>
                        </div>
                    </div>

                    <div class="text-center">
                        <input type="hidden" name="id" value="{{$id ?? 0}}">
                        <input type="hidden" name="developer_id" value="{{$developer_id or 0}}">
                        <input type="submit" class="button small-width save" value="保存">
                        <a class="button small-width clone" href="JavaScript:history.back();">返回</a>
                    </div>
                </aside>
            </form>
        </div>
    </div>
    @include('common.add-picture-item')
    @include('common.success-pop')
    @include('common.loading-pop')
    @include('common.prompt-pop',['type'=>1])
    @include('common.select-product-pop',['product_categories' => $main_category ?? [],
        'product_category_ids' => $product_category_ids ?? [],])

    @include('common.select-project-pop',['project_categories' => $project_main_category ?? [],
        'project_category_ids' => $develop_project_has_project_category_ids ?? [],])
@endsection