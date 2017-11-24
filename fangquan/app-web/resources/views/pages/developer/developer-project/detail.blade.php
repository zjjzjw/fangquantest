<?php
ufa()->extCss([
    'developer/developer-project/detail'
]);
ufa()->extJs(array(
    'developer/developer-project/detail'
));
ufa()->addParam(
    [
        'developer_project_id' => $id ?? 0,
        'token'                => csrf_token(),
    ]);
?>
@extends('layouts.master')
@section('master.content')
    @include('partials.header')
    <div class="main-content">
        <div class="company-detail">
            <div class="left-box">
                <div class="left-content">
                    <div class="project-theme">
                        <div class="project-name">
                            <h3>{{ $name or '' }}</h3>
                        </div>
                        <div class="project-cllection">
                            @if($has_favorite)
                                <a href="javascript:;" class="close-collection" data-id="{{ $id or 0 }}">
                                    <i class="iconfont">&#xe68c;</i>已收藏
                                </a>
                            @else
                                <a href="javascript:;" class="collection" data-id="{{ $id or 0 }}">
                                    <i class="iconfont ">&#xe68c;</i>加入收藏
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="project-stage">
                        <div class="stage-content">
                            <div class="project-comment project-plan">
                                <div class="graph  @if(1 == $project_stage_id) happening
                                                   @elseif (1 < $project_stage_id) happened @endif">
                                    <i class="iconfont">&#xe63e;</i>
                                </div>
                                <p>构思</p>
                            </div>
                            <div class="connect">
                                <div class="connect-line"></div>
                            </div>
                            <div class="project-comment project-design">
                                <div class="graph  @if(2 == $project_stage_id) happening
                                                   @elseif (2 < $project_stage_id) happened @endif">
                                    <i class="iconfont">&#xe6fd;</i>
                                </div>
                                <p>设计</p>
                            </div>
                            <div class="connect">
                                <div class="connect-line"></div>
                            </div>
                            <div class="project-comment project-draft">
                                <div class="graph @if(3 == $project_stage_id) happening
                                                   @elseif (3 < $project_stage_id) happened @endif">
                                    <i class="iconfont">&#xe687;</i>
                                </div>
                                <p>文章草议</p>
                            </div>
                            <div class="connect">
                                <div class="connect-line-short"></div>
                            </div>
                            <div class="connect-frame">
                                <div class="project-comment project-bid">
                                    <div class="graph @if(4 == $project_stage_id) happening
                                                   @elseif ($project_stage_id>4) happened @endif">
                                        <i class="iconfont">&#xe664;</i>
                                    </div>
                                    <p>施工单位招标</p>
                                </div>
                                <div class="connect">
                                    <div class="connect-line special-line"></div>
                                </div>
                                <div class="project-comment project-didden">
                                    <div class="graph @if(5 == $project_stage_id) happening
                                                   @elseif (5 < $project_stage_id) happened @endif">
                                        <i class="iconfont">&#xe669;</i>
                                    </div>
                                    <p>截标后</p>
                                </div>
                            </div>
                            <div class="project-time">
                                <p>招标时间</p>
                                <p>
                                    <span>{{ $stage_time['start_time'] or '暂无' }}</span>-<span>{{ $stage_time['closing_time'] or '暂无' }}</span>
                                </p>
                            </div>
                            <div class="connect">
                                <div class="connect-line-short"></div>
                            </div>
                            <div class="project-comment project-start">
                                <div class="graph @if(6 == $project_stage_id) happening
                                                   @elseif ( 6 < $project_stage_id) happened @endif">
                                    <i class="iconfont">&#xe679;</i>
                                </div>
                                <p>主体工程中标/开工</p>
                            </div>
                            <div class="connect">
                                <div class="connect-line special-short-line"></div>
                            </div>
                            <div class="project-comment project-decorate">
                                <div class="graph @if(7 == $project_stage_id) happening
                                                   @elseif (7 < $project_stage_id) happened @endif">
                                    <i class="iconfont">&#xe604;</i>
                                </div>
                                <p>室内装修/封顶后分包工程</p>
                            </div>
                        </div>
                    </div>

                    <div class="project-information">
                        <h3>项目信息</h3>
                        <table class="table" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td class="cell-style">项目编号</td>
                                <td class="cell-develop" id="cell-color">
                                    {{ $id or 0 }}
                                </td>
                                <td class="cell-style">发布时间</td>
                                <td class="cell-develop" id="cell-color">
                                    {{ $time or '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="cell-style">开发商</td>
                                <td class="cell-develop" id="cell-color">
                                    {{ $developer_info['name'] or '' }}
                                </td>
                                <td rowspan="2" class="cell-style cell-area">所在地区</td>
                                <td rowspan="2" class='cell-area-detail' id="cell-color">
                                    {{ $province or '' }}{{ $city or '' }}{{ $address or '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="cell-style">项目类型</td>
                                <td class="cell-develop" id="cell-color">
                                    {{ $type_name or '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="cell-style">项目工期</td>
                                <td class="cell-develop" id="cell-color">
                                    {{ $project_start or '' }} - {{ $project_end or '' }}
                                </td>
                                <td class="cell-style">主体设计阶段</td>
                                <td class="cell-develop" id="cell-color">
                                    {{ $project_stage_design_name or '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="cell-style">主体施工阶段</td>
                                <td class="cell-develop" id="cell-color">
                                    {{ $project_stage_build_name or '' }}
                                </td>
                                <td class="cell-style">室内精装修阶段</td>
                                <td class="cell-develop" id="cell-color">
                                    {{ $project_stage_decorate_name or '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="cell-style">建筑面积</td>
                                <td class="cell-develop" id="cell-color">
                                    {{ $floor_space or '' }}平方米
                                </td>
                                <td class="cell-style">建筑层数</td>
                                <td class="cell-develop" id="cell-color">
                                    {{ $floor_numbers or '' }}层
                                </td>
                            </tr>
                            <tr>
                                <td class="cell-style">造价</td>
                                <td class="cell-develop" id="cell-color">
                                    {{ $cost or '' }}万元
                                </td>
                                <td class="cell-style">总投资额</td>
                                <td class="cell-develop" id="cell-color">
                                    {{ $investments or '' }}万元
                                </td>
                            </tr>
                            <tr>
                                <td class="cell-style">供暖方式</td>
                                <td class="cell-develop" id="cell-color">
                                    {{ $heating_mode or '' }}
                                </td>
                                <td class="cell-style">外墙材料</td>
                                <td class="cell-develop" id="cell-color">
                                    {{ $wall_materials or $wall_materials ? $wall_materials : '未知' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="cell-style">是否精装修</td>
                                <td class="cell-develop" id="cell-color">
                                    {{ $has_decorate_name or '未知' }}
                                </td>
                                <td class="cell-style">有无空调</td>
                                <td class="cell-develop" id="cell-color">
                                    {{ $project_airconditioner_name or '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="cell-style">有无钢结构</td>
                                <td class="cell-develop" id="cell-color">
                                    {{ $project_steel_name or '' }}
                                </td>
                                <td class="cell-style">有无电梯</td>
                                <td class="cell-develop" id="cell-color">
                                    {{ $project_elevator_name or '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="cell-style">所需材料</td>
                                <td colspan="3" class="cell-develop" id="cell-color">
                                    <strong>{{ $product_category_names or '' }}</strong>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="project-situation">
                        <h3>项目概况</h3>
                        <div class="situation-content">
                            @if(!empty($summary))
                                <pre>{{ $summary or '' }}</pre>
                            @else
                                @include('common.no-data',['title'=> '暂无数据'])
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="right-box">

                @if(!empty($developer_info))
                    <div class="right-comment company-rank">
                        <div class="rank">
                            @if($developer_info['rank']==1) <img src="/www/images/developer/bq1.png" alt="">
                            @elseif($developer_info['rank']==2)<img src="/www/images/developer/bq2.png" alt="">
                            @elseif($developer_info['rank']==3)<img src="/www/images/developer/bq3.png" alt="">
                            @else<img src="/www/images/developer/bq.png" alt="">
                            @endif
                            <span>{{$developer_info['rank'] or ''}}</span>
                        </div>
                        <div class="company-logo">
                            <img src="{{ $developer_info['developer_logo_url'] or '' }}"
                                 alt="{{ $developer_info['name'] or '' }}">
                        </div>
                        <div class="company-name">
                            <p>{{ $developer_info['name'] or '' }}</p>
                        </div>
                    </div>
                @endif

                <div class="right-comment project-heat">
                    <p>
                        <span>项目热度</span>
                        <span class="heat-detail">
                    @for($hot_num=0; $hot_num < $project_hot['hot'] ; $hot_num++)
                                <i class="iconfont">&#xe643;</i>
                            @endfor
                        </span>
                    </p>
                    <p class="join-number">
                        <span>参与供应商数量:</span>
                        <span class="heat-detail">{{ $project_hot['project_contact_visit_count'] or 0 }}</span>
                    </p>
                </div>
                <div class="right-comment">
                    <div class="contact-way">
                        <span>查看联系方式</span>
                    </div>
                </div>
                <div class="contact-list">

                </div>
            </div>
        </div>
    </div>
    <div class="clear-both"></div>

    @include('common.contact-pop')
    @include('common.login-pop')
    {{--@include('common.server-error')--}}
    @include('common.back-top')
    @if(!empty($ad_developer_projects))
        <div class="recommend-project">
            <div class="recommend">
                <div class="recommend-title">
                    推荐项目
                </div>
                <ul>
                    @foreach($ad_developer_projects ?? [] as $ad_developer_project)
                        <li>
                            <i></i>
                            <a href="{{route('developer.developer-project.detail',['developer_project_id' => $ad_developer_project['id']])}}">
                                {{ $ad_developer_project['name'] or '' }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif


    <script type="text/html" id="contact_list_tpl">

        <div class="contact-information">
            <h3>联系人</h3>

            <% for ( var i = 0; i < contacts.length; i++ ) { %>
            <div class="project-contact">
                <p><%=contacts[i]['type_name']%></p>
                    <% for ( var j = 0; j < contacts[i].nodes.length; j++ ) { %>
                        <ul>
                            <li>
                                <%=contacts[i].nodes[j].company_name%>
                            </li>
                            <li>
                                <%=contacts[i].nodes[j].contact_name%>
                            </li>
                            <li>
                                <i class="iconfont">&#xe6ff;</i>
                                <span><%=contacts[i].nodes[j].address%></span>
                            </li>
                            <li>
                                <i class="iconfont">&#xe63a;</i>
                                <span><%=contacts[i].nodes[j].mobile%></span>
                            </li>
                            <li>
                                备注：
                                <span><%=contacts[i].nodes[j].remark%></span>
                            </li>

                        </ul>

                    <% } %>
                    <div class="clear-both"></div>
                </div>

             <% } %>

        </div>
</script>


@endsection