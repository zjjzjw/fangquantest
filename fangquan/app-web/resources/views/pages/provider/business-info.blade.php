<?php
ufa()->extCss([
    'provider/business-info'
]);
ufa()->extJs([
    'provider/business-info',
]);
?>
@extends('layouts.master')
@section('master.content')
    @include('partials.header')

    <div class="main-content">
    @include('partials.provider.company-desc-top')
    @include('partials.provider.company-info-left')
    <!--右侧-工商信息-->
        <div class="right-box">
            <div class="business-info">
                <div class="business-item">
                    <div class="info-box box-one">
                        <div class="range-title">
                            <h3>企业背景</h3>
                        </div>
                        <div class="title">
                            <span>基本信息</span>
                        </div>
                        <table class="table companyInfo-table">
                            <thead>
                            <tr>
                                <td>法人代表</td>
                                <td>注册资本</td>
                                <td>注册时间</td>
                                <td>经营状态</td>
                            </tr>
                            </thead>
                            <tr>
                                <td>{{ $json_light['base_info']['legal_representative'] or '' }}</td>
                                <td>{{ $json_light['base_info']['registered_capital'] or '' }}</td>
                                <td>{{ $json_light['base_info']['registered_time'] or '' }}</td>
                                <td>{{ $json_light['base_info']['management_status'] or '' }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <ul class="basic_info">
                            <li>
                                <span class="title">工商注册号：</span>
                                <span class="content">{{ $json_light['base_info']['business_registration_number'] or '' }}</span>
                            </li>
                            <li>
                                <span class="title">组织机构代码：</span>
                                <span class="content">{{ $json_light['base_info']['organization_code'] or '' }}</span>
                            </li>
                            <li>
                                <span class="title">统一信用代码：</span>
                                <span class="content">{{ $json_light['base_info']['uniform_credit_code'] or '' }}</span>
                            </li>
                            <li>
                                <span class="title">企业类型：</span>
                                <span class="content">{{ $json_light['base_info']['industry'] or '' }}</span>
                            </li>
                            <li>
                                <span class="title">行业：</span>
                                <span class="content">{{ $json_light['base_info']['enterprise_type'] or '' }}</span>
                            </li>
                            <li>
                                <span class="title">营业期限：</span>
                                <span class="content">{{ $json_light['base_info']['business_term'] or '' }}</span>
                            </li>
                            <li>
                                <span class="title">核准日期：</span>
                                <span class="content">{{ $json_light['base_info']['approval_date'] or '' }}</span>
                            </li>
                            <li>
                                <span class="title">登记机关：</span>
                                <span class="content">{{ $json_light['base_info']['registration_authority'] or '' }}</span>
                            </li>
                            <li class="address">
                                <span class="title">注册地址：</span>
                                <span class="content">{{ $json_light['base_info']['registered_address'] or '' }}</span>
                            </li>
                            <li class="bussiness-range">
                                <span class="title">经营范围：</span>
                                <span class="details">
                                    <em>{{ $json_light['base_info']['scope_of_business'] or '' }}</em>
                                    <a href="javascript:void(0);" class="open-all open-comm-desc">查看全部&nbsp;&nbsp;<i
                                            class="iconfont">&#xe614;</i></a>
                                </span>
                            </li>
                        </ul>

                        @if(count($json_light['main_person'] ?? []) > 0)
                            <div class="title">
                                <span>主要人员（<em>{{ count($json_light['main_person'] ?? []) }}</em>）</span>
                            </div>
                            <ul class="key-personnel">
                                @foreach($json_light['main_person'] ?? [] as $main_person_one)
                                    <li>
                                    <span class="title">
                                        @foreach($main_person_one['post'] ?? [] as $value)
                                            {{ $value }} &nbsp;
                                        @endforeach
                                    </span>
                                        <span class="content">{{ $main_person_one['name'] or '' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        @if(count($json_light['shareholder_info'] ?? []) > 0)
                            <div class="title">
                                <span>股东信息（<em>{{ count($json_light['shareholder_info'] ?? []) }}</em>）</span>
                            </div>
                            <table class="table stockholder-table">
                                <thead>
                                <tr>
                                    <td>股东</td>
                                    <td>出资比例</td>
                                    <td>认缴出资</td>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($json_light['shareholder_info'] ?? [] as $shareholder_item)
                                    <tr>
                                        <td class="name">{{ $shareholder_item['shareholder'] or '' }}</td>
                                        <td class="per">{{ $shareholder_item['contributive_proportion'] or '' }}</td>
                                        <td>{{ $shareholder_item['subscribed_capital_contribution'] or '' }}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        @endif


                        @if(count($json_light['change_record'] ?? []) > 0)
                            <div class="title">
                                <span>变更记录（<em>{{ count($json_light['change_record'] ?? []) }}</em>）</span>
                            </div>
                            <table class="table change-table">
                                <thead>
                                <tr>
                                    <td>变更时间</td>
                                    <td>变更项目</td>
                                    <td>变更前</td>
                                    <td>变更后</td>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($json_light['change_record'] ?? [] as $change_record_item)
                                    <tr>
                                        <td>{{ $change_record_item['change_time'] or '' }}</td>
                                        <td>{{ $change_record_item['change_project'] or '' }}</td>
                                        <td>{{ $change_record_item['change_before'] or '' }}</td>
                                        <td>{{ $change_record_item['change_after'] or '' }}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        @endif

                        @if(count($json_light['branchs'] ?? []) > 0)
                            <div class="title">
                                <span>分支机构（<em>{{ count($json_light['branchs'] ?? []) }}</em>）</span>
                            </div>
                            <table class="table branches-table">
                                <thead>
                                <tr>
                                    <td>企业名称</td>
                                    <td>法定代表人</td>
                                    <td>状态</td>
                                    <td>注册时间</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($json_light['branchs'] ?? [] as $branch)
                                    <tr>
                                        <td>{{ $branch['enterprise_name'] or '' }}</td>
                                        <td>{{ $branch['legal_representative'] or '' }}</td>
                                        <td>{{ $branch['status'] or '' }}</td>
                                        <td>{{ $branch['register_time'] or '' }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif

                    </div>
                </div>

                @if(!empty($json_light['financing_history']) || !empty($json_light['core_team']) || !empty($json_light['enterprise_business']) || !empty($json_light['enterprise_business']))
                    <div class="business-item">
                        <div class="info-box box-two">

                            <div class="range-title">
                                <h3>企业发展</h3>
                            </div>

                            @if(!empty($json_light['financing_history']))
                                <div class="title">
                                    <span>融资历史（<em>{{ count($json_light['financing_history'] ?? []) }}</em>）</span>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <td>时间</td>
                                        <td>轮次</td>
                                        <td>估值</td>
                                        <td>金额</td>
                                        <td>比例</td>
                                        <td>投资方</td>
                                        <td>新闻来源</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($json_light['financing_history'] ?? [] as $financing_history_item)
                                        <tr>
                                            <td>{{ $financing_history_item['time'] or '' }}</td>
                                            <td>{{ $financing_history_item['round'] or '' }}</td>
                                            <td>{{ $financing_history_item['valuation'] or '' }}</td>
                                            <td>{{ $financing_history_item['money'] or '' }}</td>
                                            <td>{{ $financing_history_item['proportion'] or '' }}</td>
                                            <td>{{ $financing_history_item['investors'] or '' }}</td>
                                            <td>{{ $financing_history_item['news_source'] or '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                            @if(!empty($json_light['core_team']))
                                <div class="title">
                                    <span>核心团队（<em>{{ count($json_light['core_team'] ?? []) }}</em>）</span>
                                </div>
                                <ul class="team">
                                    @foreach($json_light['core_team'] ?? [] as $core_team)
                                        <li class="team-item">
                                            <div class="person-info">
                                                <img src="">
                                                <p class="name">{{ $core_team['name'] or '' }}</p>
                                            </div>
                                            <div class="person-detail">
                                                <p class="position">{{ $core_team['post'] or '' }}</p>
                                                <div class="des-info">
                                                    <span>·</span>
                                                    <p>{{ $core_team['content'] or '' }}</p>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            @if(!empty($json_light['enterprise_business']))
                                <div class="title">
                                    <span>企业业务（<em>{{ count($json_light['enterprise_business'] ?? []) }}</em>）</span>
                                </div>
                                <ul class="business">
                                    @foreach($json_light['enterprise_business'] ?? [] as $enterprise_business)
                                        <li class="business-item">
                                            <img src="{{ $enterprise_business['img_url'] or '' }}">
                                            <div class="des-info">
                                                <p class="name">{{ $enterprise_business['business_name'] or '' }}</p>
                                                <p class="name">{{ $enterprise_business['business_introduce'] or '' }}</p>
                                                <p class="detail-info">{{ $enterprise_business['content'] or '' }}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                        </div>
                    </div>
                @endif

                @if(!empty($json_light['legal_proceedings']) || !empty($json_light['court_notice']) || !empty($json_light['dishonest_person']) || !empty($json_light['dishonest_person']) || !empty($json_light['person_subjected_execution']))
                    <div class="business-item">
                        <div class="info-box box-three">
                            <div class="range-title">
                                <h3>司法风险</h3>
                            </div>

                            @if(!empty($json_light['legal_proceedings']))
                                <div class="title">
                                    <span>法律诉讼（<em>{{ count($json_light['legal_proceedings'] ?? []) }}</em>）</span>
                                </div>
                                <table class="table">
                                <thead>
                                    <tr>
                                        <td>日期</td>
                                        <td>裁判文书</td>
                                        <td>文件类型</td>
                                        <td>案件号</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($json_light['legal_proceedings'] ?? [] as $legal_proceedings)
                                        <tr>
                                            <td>{{ $legal_proceedings['time'] or '' }}</td>
                                            <td>{{ $legal_proceedings['referee_documen'] or '' }}</td>
                                            <td>{{ $legal_proceedings['documen_type'] or '' }}</td>
                                            <td>{{ $legal_proceedings['document_number'] or '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                            @if(!empty($json_light['court_notice']))
                                <div class="title">
                                    <span>法院公告（<em>{{ count($json_light['court_notice'] ?? []) }}</em>）</span>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <td>公告时间</td>
                                        <td>上诉方</td>
                                        <td>被诉方</td>
                                        <td>公告类型</td>
                                        <td>法院</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($json_light['court_notice'] ?? [] as $court_notice)
                                        <tr>
                                            <td>{{ $legal_proceedings['time'] or '' }}</td>
                                            <td>{{ $legal_proceedings['appellant'] or '' }}</td>
                                            <td>{{ $legal_proceedings['defendant'] or '' }}</td>
                                            <td>{{ $legal_proceedings['announcement_type'] or '' }}</td>
                                            <td>{{ $legal_proceedings['court'] or '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                            @if(!empty($json_light['dishonest_person']))
                                <div class="title">
                                    <span>失信人（<em>{{ count($json_light['dishonest_person'] ?? []) }}</em>）</span>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <td>立案日期</td>
                                        <td>案号</td>
                                        <td>执行法院</td>
                                        <td>履行状态</td>
                                        <td>执行依据文号</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($json_light['dishonest_person'] ?? [] as $dishonest_person)
                                        <tr>
                                            <td>{{ $dishonest_person['time'] or '' }}</td>
                                            <td>{{ $dishonest_person['case_no'] or '' }}</td>
                                            <td>{{ $dishonest_person['court_execution'] or '' }}</td>
                                            <td>{{ $dishonest_person['time'] or '' }}</td>
                                            <td>{{ $dishonest_person['time'] or '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                            @if(!empty($json_light['person_subjected_execution']))
                                <div class="title">
                                    <span>被执行人（<em>{{ count($json_light['person_subjected_execution'] ?? []) }}</em>）</span>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <td>立案日期</td>
                                        <td>执行标的</td>
                                        <td>案号</td>
                                        <td>行法院</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($json_light['person_subjected_execution'] ?? [] as $person_subjected_execution)
                                        <tr>
                                            <td>{{ $person_subjected_execution['time'] or '' }}</td>
                                            <td>{{ $person_subjected_execution['object_execution'] or '' }}</td>
                                            <td>{{ $person_subjected_execution['case_no'] or '' }}</td>
                                            <td>{{ $person_subjected_execution['court_justice'] or '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                        </div>
                    </div>
                @endif

                @if (!empty($json_light['abnormal_operation']) || !empty($json_light['administrative_sanction']) || !empty($json_light['serious_violation']) || !empty($json_light['stock_ownership']) || !empty($json_light['stock_ownership']) || !empty($json_light['chattel_mortgage']) || !empty($json_light['tax_notice']))
                    <div class="business-item">
                        <div class="info-box box-four">
                            <div class="range-title">
                                <h3>经营风险</h3>
                            </div>

                            @if(!empty($json_light['abnormal_operation']))
                                <div class="title">
                                    <span>经营异常（<em>{{ count($json_light['abnormal_operation'] ?? []) }}</em>）</span>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <td>列入日期</td>
                                        <td>列入原因</td>
                                        <td>决定机关</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($json_light['abnormal_operation'] ?? [] as $abnormal_operation)
                                        <tr>
                                            <td>{{ $abnormal_operation['time'] or '' }}</td>
                                            <td>{{ $abnormal_operation['case'] or '' }}</td>
                                            <td>{{ $abnormal_operation['decision_organ'] or '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                            @if(!empty($json_light['administrative_sanction']))
                                <div class="title">
                                    <span>行政处罚（<em>{{ count($json_light['administrative_sanction'] ?? []) }}</em>）</span>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <td>决定日期</td>
                                        <td>决定书文号</td>
                                        <td>类型</td>
                                        <td>决定机关</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($json_light['administrative_sanction'] ?? [] as $administrative_sanction)
                                        <tr>
                                            <td>{{ $administrative_sanction['time'] or '' }}</td>
                                            <td>{{ $administrative_sanction['letter_decision'] or '' }}</td>
                                            <td>{{ $administrative_sanction['type'] or '' }}</td>
                                            <td>{{ $administrative_sanction['decision_organ'] or '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                            @if(!empty($json_light['serious_violation']))
                                <div class="title">
                                    <span>严重违法（<em>{{ count($json_light['serious_violation'] ?? []) }}</em>）</span>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <td>列入日期</td>
                                        <td>列入原因</td>
                                        <td>决定机关</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($json_light['serious_violation'] ?? [] as $serious_violation)
                                        <tr>
                                            <td>{{ $serious_violation['time'] or '' }}</td>
                                            <td>{{ $serious_violation['executive_council'] or '' }}</td>
                                            <td>{{ $serious_violation['decision_organ'] or '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                            @if(!empty($json_light['stock_ownership']))
                                <div class="title">
                                    <span>股权出质（<em>{{ count($json_light['stock_ownership'] ?? []) }}</em>）</span>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <td>列入日期</td>
                                        <td>登记编号</td>
                                        <td>出质人</td>
                                        <td>质权人</td>
                                        <td>状态</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($json_light['stock_ownership'] ?? [] as $stock_ownership)
                                        <tr>
                                            <td>{{ $stock_ownership['time'] or '' }}</td>
                                            <td>{{ $stock_ownership['registration_number'] or '' }}</td>
                                            <td>{{ $stock_ownership['pledgor'] or '' }}</td>
                                            <td>{{ $stock_ownership['apledgee'] or '' }}</td>
                                            <td>{{ $stock_ownership['status'] or '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                            @if(!empty($json_light['chattel_mortgage']))
                                <div class="title">
                                    <span>动产抵押（<em>{{ count($json_light['chattel_mortgage'] ?? []) }}</em>）</span>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <td>登记日期</td>
                                        <td>登记号</td>
                                        <td>被担保债券类型</td>
                                        <td>登记机关</td>
                                        <td>状态</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($json_light['chattel_mortgage'] ?? [] as $chattel_mortgage)
                                        <tr>
                                            <td>{{ $chattel_mortgage['time'] or '' }}</td>
                                            <td>{{ $chattel_mortgage['registration_number'] or '' }}</td>
                                            <td>{{ $chattel_mortgage['types_secured_bonds'] or '' }}</td>
                                            <td>{{ $chattel_mortgage['registration_authority'] or '' }}</td>
                                            <td>{{ $chattel_mortgage['status'] or '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                            @if(!empty($json_light['tax_notice']))
                                <div class="title">
                                    <span>欠税公告（<em>{{ count($json_light['tax_notice'] ?? []) }}</em>）</span>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <td>发布日期</td>
                                        <td>纳税人认别号</td>
                                        <td>欠税税种</td>
                                        <td>当前发生的欠税额</td>
                                        <td>欠税余额</td>
                                        <td>税务机关</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($json_light['tax_notice'] ?? [] as $tax_notice)
                                        <tr>
                                            <td>{{ $tax_notice['time'] or '' }}</td>
                                            <td>{{ $tax_notice['taxpayers_that_alias'] or '' }}</td>
                                            <td>{{ $tax_notice['taxes_taxes'] or '' }}</td>
                                            <td>{{ $tax_notice['current_tax_credits'] or '' }}</td>
                                            <td>{{ $tax_notice['balance_tax_arrears'] or '' }}</td>
                                            <td>{{ $tax_notice['tax_authority'] or '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                        </div>
                    </div>
                @endif

                @if (!empty($json_light['bidding']) || !empty($json_light['purchase_information']) || !empty($json_light['tax_rating']) || !empty($json_light['qualification_certificate']))
                    <div class="business-item">
                        <div class="info-box box-five">
                            <div class="range-title">
                                <h3>经营状况</h3>
                            </div>

                            @if(!empty($json_light['bidding']))
                                <div class="title">
                                    <span>招投标（<em>{{ count($json_light['bidding'] ?? []) }}</em>）</span>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <td>发布时间</td>
                                        <td>标题</td>
                                        <td>采购人</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($json_light['bidding'] ?? [] as $bidding)
                                        <tr>
                                            <td>{{ $bidding['time'] or '' }}</td>
                                            <td>{{ $bidding['title'] or '' }}</td>
                                            <td>{{ $bidding['purchaser'] or '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                            @if(!empty($json_light['purchase_information']))
                                <div class="title">
                                    <span>购地信息（<em>{{ count($json_light['purchase_information'] ?? []) }}</em>）</span>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <td>发布日期</td>
                                        <td>电子监管号</td>
                                        <td>约定动工日</td>
                                        <td>供地总面积</td>
                                        <td>行政区</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($json_light['bidding'] ?? [] as $bidding)
                                        <tr>
                                            <td>{{ $bidding['time'] or '' }}</td>
                                            <td>{{ $bidding['electronic_regulatory_number'] or '' }}</td>
                                            <td>{{ $bidding['agreed_commencement_date'] or '' }}</td>
                                            <td>{{ $bidding['gross_floor_area'] or '' }}</td>
                                            <td>{{ $bidding['administrative_region'] or '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                            @if(!empty($json_light['tax_rating']))
                                <div class="title">
                                    <span>税务评级（<em>{{ count($json_light['tax_rating'] ?? []) }}</em>）</span>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <td>年份</td>
                                        <td>纳税评级</td>
                                        <td>类型</td>
                                        <td>纳税人识别号</td>
                                        <td>评价单位</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($json_light['tax_rating'] ?? [] as $tax_rating)
                                        <tr>
                                            <td>{{ $tax_rating['particular_year'] or '' }}</td>
                                            <td>{{ $tax_rating['tax_rating'] or '' }}</td>
                                            <td>{{ $tax_rating['type'] or '' }}</td>
                                            <td>{{ $tax_rating['taxpayer_identification_number'] or '' }}</td>
                                            <td>{{ $tax_rating['evaluation_unit'] or '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                            @if(!empty($json_light['qualification_certificate']))
                                <div class="title">
                                    <span>资质证书（<em>{{ count($json_light['qualification_certificate'] ?? []) }}</em>）</span>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <td>设备名称</td>
                                        <td>证书类型</td>
                                        <td>发证日期</td>
                                        <td>截止日期</td>
                                        <td>设备编号</td>
                                        <td>许可编号</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($json_light['qualification_certificate'] ?? [] as $qualification_certificate)
                                        <tr>
                                            <td>{{ $qualification_certificate['device_name'] or '' }}</td>
                                            <td>{{ $qualification_certificate['certificate_type'] or '' }}</td>
                                            <td>{{ $qualification_certificate['date_issue'] or '' }}</td>
                                            <td>{{ $qualification_certificate['closing_date'] or '' }}</td>
                                            <td>{{ $qualification_certificate['device_number'] or '' }}</td>
                                            <td>{{ $qualification_certificate['license_number'] or '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                        </div>
                    </div>
                @endif

                @if(!empty($json_light['trademark_information']) || !empty($json_light['patent']))
                    <div class="business-item">
                        <div class="info-box box-six">
                            <div class="range-title">
                                <h3>知识产权</h3>
                            </div>

                            @if(!empty($json_light['trademark_information']))
                                <div class="title">
                                    <span>商标信息（<em>{{ count($json_light['trademark_information'] ?? []) }}</em>）</span>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <td>申请日期</td>
                                        <td>商标</td>
                                        <td>商标名称</td>
                                        <td>注册号</td>
                                        <td>类别</td>
                                        <td>状态</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($json_light['trademark_information'] ?? [] as $trademark_information)
                                        <tr>
                                            <td>{{ $trademark_information['date_application'] or '' }}</td>
                                            <td><img src="{{ $trademark_information['trademark'] or '' }}"
                                                     style="width: 50px;height: 50px"></td>
                                            <td>{{ $trademark_information['trademark_name'] or '' }}</td>
                                            <td>{{ $trademark_information['register_number'] or '' }}</td>
                                            <td>{{ $trademark_information['type'] or '' }}</td>
                                            <td>{{ $trademark_information['status'] or '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                            @if(!empty($json_light['patent']))
                                <div class="title">
                                    <span>专利（<em>{{ count($json_light['patent'] ?? []) }}</em>）</span>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <td>申请公布日</td>
                                        <td>专利名称</td>
                                        <td>申请号</td>
                                        <td>申请公布号</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($json_light['patent'] ?? [] as $patent)
                                        <tr>
                                            <td>{{ $patent['application_date'] or '' }}</td>
                                            <td>{{ $patent['patent_name'] or '' }}</td>
                                            <td>{{ $patent['application_number'] or '' }}</td>
                                            <td>{{ $patent['application_publication_number'] or '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection